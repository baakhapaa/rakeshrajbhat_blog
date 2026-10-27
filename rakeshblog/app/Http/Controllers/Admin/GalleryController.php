<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\GalleryCollection;
use App\Models\GalleryImage;
use App\Support\GalleryImageCompressor;
use App\Support\MediaStorage;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $collections = GalleryCollection::withCount('images')
            ->with('images')
            ->ordered()
            ->get();

        return view('admin.gallery.index', compact('collections'));
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
            'image_positions' => 'nullable|array',
            'image_positions.*' => 'string|max:32',
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

        $created = $this->attachImages($collection, $paths);
        $this->syncImageOrder($collection, $request, $created);

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
            'image_positions' => 'nullable|array',
            'image_positions.*' => 'string|max:32',
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

        $created = $this->attachImages($gallery, $paths);
        $this->syncImageOrder($gallery, $request, $created);

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
        $paths = [];

        foreach ($request->file('images', []) as $file) {
            $temporary = null;

            try {
                if (! GalleryImageCompressor::exceedsLimit($file)) {
                    $paths[] = $file->store('gallery', 'media');
                    continue;
                }

                $temporary = GalleryImageCompressor::compress($file);
                $stored = Storage::disk('media')->putFile('gallery', new File($temporary));

                if ($stored === false) {
                    throw new \RuntimeException('Could not store the compressed photograph.');
                }

                $paths[] = $stored;
            } catch (\RuntimeException $exception) {
                $this->deleteStoredPaths($paths);

                return $exception->getMessage();
            } catch (\Throwable $exception) {
                Log::error('Gallery upload failed.', [
                    'error' => $exception->getMessage(),
                ]);
                $this->deleteStoredPaths($paths);

                return 'Could not upload the photographs. Please try again.';
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
            MediaStorage::delete($path);
        }
    }

    /**
     * @param  array<int, string>  $paths
     * @return array<int, GalleryImage>
     */
    private function attachImages(GalleryCollection $collection, array $paths): array
    {
        $order = (int) $collection->images()->max('order');
        $created = [];

        foreach ($paths as $path) {
            $order++;
            $created[] = $collection->images()->create([
                'path' => $path,
                'order' => $order,
            ]);
        }

        return $created;
    }

    /**
     * The first photograph is the large image. The next three are the smaller ones.
     *
     * @param  array<int, GalleryImage>  $created
     */
    private function syncImageOrder(GalleryCollection $collection, Request $request, array $created): void
    {
        $positions = $request->input('image_positions', []);
        if (! is_array($positions) || $positions === []) {
            return;
        }

        $ids = $collection->images()->pluck('id')->map(fn ($id) => (int) $id)->all();
        $orderedIds = [];

        foreach ($positions as $token) {
            if (! is_string($token)) {
                continue;
            }

            $id = null;
            if (str_starts_with($token, 'existing:')) {
                $id = (int) substr($token, 9);
            } elseif (str_starts_with($token, 'new:') && isset($created[(int) substr($token, 4)])) {
                $id = $created[(int) substr($token, 4)]->id;
            }

            if ($id && in_array($id, $ids, true) && ! in_array($id, $orderedIds, true)) {
                $orderedIds[] = $id;
            }
        }

        foreach ($ids as $id) {
            if (! in_array($id, $orderedIds, true)) {
                $orderedIds[] = $id;
            }
        }

        foreach ($orderedIds as $index => $id) {
            GalleryImage::where('id', $id)->update(['order' => $index + 1]);
        }
    }
}
