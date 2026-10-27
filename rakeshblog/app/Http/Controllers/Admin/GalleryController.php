<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\GalleryCollection;
use App\Models\Setting;
use App\Models\GalleryImage;
use App\Support\GalleryImageCompressor;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $collections = GalleryCollection::withCount('images')
            ->with('images')
            ->ordered()
            ->get();

        $gallerySection = Setting::getGallerySection();

        return view('admin.gallery.index', compact('collections', 'gallerySection'));
    }

    public function updateSection(Request $request)
    {
        $validated = $request->validate([
            'gallery_section_label' => 'required|string|max:40',
            'gallery_section_title' => 'required|string|max:120',
            'gallery_section_paragraph' => 'required|string|max:400',
            'gallery_section_empty' => 'required|string|max:200',
        ]);

        Setting::setValue('gallery_section_label', trim(strip_tags($validated['gallery_section_label'])));
        Setting::setValue('gallery_section_title', trim(strip_tags($validated['gallery_section_title'])));
        Setting::setValue('gallery_section_paragraph', trim(strip_tags($validated['gallery_section_paragraph'])));
        Setting::setValue('gallery_section_empty', trim(strip_tags($validated['gallery_section_empty'])));

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery heading updated.');
    }

    public function create()
    {
        $nextOrder = (int) GalleryCollection::max('order') + 1;

        return view('admin.gallery.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'images' => 'nullable|array|max:1000',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp,gif|max:32768',
        ]);

        $paths = $this->storeImages($request);
        if (! is_array($paths)) {
            return back()->withInput()->withErrors([
                'images' => $paths,
            ]);
        }

        $collection = GalleryCollection::create([
            'title' => trim($validated['title']),
            'order' => $validated['order'] ?? ((int) GalleryCollection::max('order') + 1),
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->attachImages($collection, $paths);

        ActivityLogger::log('gallery_collection_created', 'Created gallery collection "'.$collection->title.'"');

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery collection created.');
    }

    public function edit(GalleryCollection $gallery)
    {
        $gallery->load('images');

        return view('admin.gallery.edit', ['collection' => $gallery]);
    }

    public function update(Request $request, GalleryCollection $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'images' => 'nullable|array|max:1000',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp,gif|max:32768',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        $paths = $this->storeImages($request);
        if (! is_array($paths)) {
            return back()->withInput()->withErrors([
                'images' => $paths,
            ]);
        }

        $gallery->update([
            'title' => trim($validated['title']),
            'order' => $validated['order'] ?? $gallery->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        $removeIds = collect($validated['remove_images'] ?? [])->filter()->all();
        if ($removeIds) {
            $gallery->images()->whereIn('id', $removeIds)->get()->each->delete();
        }

        $this->attachImages($gallery, $paths);

        ActivityLogger::log('gallery_collection_updated', 'Updated gallery collection "'.$gallery->title.'"');

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery collection updated.');
    }

    public function destroy(GalleryCollection $gallery)
    {
        $title = $gallery->title;
        $gallery->delete();

        ActivityLogger::log('gallery_collection_deleted', 'Deleted gallery collection "'.$title.'"');

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery collection deleted.');
    }

    public function destroyImage(GalleryImage $image)
    {
        $collectionId = $image->gallery_collection_id;
        $image->delete();

        ActivityLogger::log('gallery_image_deleted', 'Removed a photograph from a gallery collection');

        return redirect()->route('admin.gallery.edit', $collectionId)
            ->with('success', 'Photograph removed.');
    }

    public function toggleStatus(GalleryCollection $gallery)
    {
        $gallery->is_active = ! $gallery->is_active;
        $gallery->save();

        ActivityLogger::log(
            'gallery_collection_status_toggled',
            'Changed gallery collection "'.$gallery->title.'" to '.($gallery->is_active ? 'active' : 'inactive')
        );

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Collection status updated.');
    }

    /**
     * Photographs over 8096 KB are compressed under that size before storage.
     *
     * @return array<int, string>|string Stored object keys, or an error message.
     */
    private function storeImages(Request $request): array|string
    {
        if (! config('filesystems.disks.gallery.key') || ! config('filesystems.disks.gallery.secret')) {
            return 'DigitalOcean Spaces credentials are missing. Add DO_SPACES_KEY and DO_SPACES_SECRET in the .env file, then try the upload again.';
        }

        $paths = [];

        foreach ($request->file('images', []) as $file) {
            $temporary = null;

            try {
                if (! GalleryImageCompressor::exceedsLimit($file)) {
                    $paths[] = $file->storePublicly('gallery', 'gallery');
                    continue;
                }

                $temporary = GalleryImageCompressor::compress($file);
                $stored = Storage::disk('gallery')->putFileAs(
                    'gallery',
                    new File($temporary),
                    (string) Str::uuid().'.jpg',
                    'public'
                );

                if ($stored === false) {
                    throw new \RuntimeException('Could not upload the compressed photograph to DigitalOcean Spaces.');
                }

                $paths[] = $stored;
            } catch (\RuntimeException $exception) {
                $this->deleteStoredPaths($paths);

                return $exception->getMessage();
            } catch (\Throwable $exception) {
                Log::error('Gallery upload to DigitalOcean Spaces failed.', [
                    'error' => $exception->getMessage(),
                ]);
                $this->deleteStoredPaths($paths);

                return 'Could not upload the photographs to DigitalOcean Spaces. Check the Spaces key and secret, then try again.';
            } finally {
                if (is_string($temporary) && is_file($temporary)) {
                    @unlink($temporary);
                }
            }
        }

        return $paths;
    }

    /**
     * @param  array<int, string>  $paths
     */
    private function deleteStoredPaths(array $paths): void
    {
        foreach ($paths as $path) {
            try {
                Storage::disk('gallery')->delete($path);
            } catch (\Throwable $exception) {
                Log::warning('Unable to remove a partial gallery upload.', [
                    'path' => $path,
                    'error' => $exception->getMessage(),
                ]);
            }
        }
    }

    /**
     * @param  array<int, string>  $paths
     */
    private function attachImages(GalleryCollection $collection, array $paths): void
    {
        $order = (int) $collection->images()->max('order');

        foreach ($paths as $path) {
            $order++;
            $collection->images()->create([
                'path' => $path,
                'order' => $order,
            ]);
        }
    }
}
