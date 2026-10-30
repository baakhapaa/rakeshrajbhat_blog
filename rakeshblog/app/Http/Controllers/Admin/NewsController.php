<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use App\Models\Setting;
use App\Services\NewsSourceReader;
use App\Support\MediaStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use InvalidArgumentException;
use RuntimeException;

class NewsController extends Controller
{
    public function index()
    {
        $items = NewsItem::query()->latest()->get();
        $section = Setting::getNewsContent();

        return view('admin.news.index', compact('items', 'section'));
    }

    public function updateSection(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:400'],
        ]);

        $decoded = json_decode((string) Setting::getValue('news_content', ''), true);

        if (! is_array($decoded)) {
            $decoded = Setting::defaultNewsContent();
        }

        $decoded['label'] = trim($validated['label']);
        $decoded['heading'] = trim($validated['heading']);
        $decoded['intro'] = trim($validated['intro']);
        Setting::setValue('news_content', Setting::encodeJson($decoded));

        return back()->with('success', 'News heading saved.');
    }

    public function store(Request $request, NewsSourceReader $reader)
    {
        $validated = $request->validate([
            'source_url' => ['required', 'string', 'max:2048'],
        ]);

        try {
            $payload = $reader->read($validated['source_url']);
        } catch (InvalidArgumentException|RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $existing = NewsItem::query()->where('source_hash', $payload['source_hash'])->first();

        if ($existing) {
            $keptImage = (bool) $existing->image_is_custom;
            $this->replaceFromSource($existing, $payload);

            return back()->with('success', $keptImage
                ? 'That link was already added, so the story was refreshed. The image you set is still used on the site.'
                : 'That link was already added, so the story and images were refreshed.');
        }

        NewsItem::query()->create($payload);

        return back()->with('success', 'News added. It is now on the homepage.');
    }

    public function updateCategory(Request $request, NewsItem $news)
    {
        $request->merge([
            'category' => $request->input('category') ?: null,
        ]);

        $validated = $request->validate([
            'category' => ['nullable', Rule::in(array_keys(NewsItem::CATEGORIES))],
        ]);

        $news->update([
            'category' => $validated['category'] ?? null,
        ]);

        return back()->with('success', 'News category saved.');
    }

    public function updateImage(Request $request, NewsItem $news)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
        ], [
            'image.required' => 'Choose an image to use for this news item.',
            'image.image' => 'Use a JPG, PNG, WEBP, or GIF image.',
            'image.mimes' => 'Use a JPG, PNG, WEBP, or GIF image.',
            'image.max' => 'That image is too large. Use one under 4 MB.',
        ]);

        $path = $validated['image']->store('news', 'media');

        if ($path === false) {
            return back()->with('error', 'The image could not be saved. Please try again.');
        }

        $url = Storage::disk('media')->url($path);
        $previous = $news->image_url;
        $images = array_values(array_filter(
            $news->images ?? [],
            fn ($image) => is_string($image) && $image !== '' && $image !== $previous
        ));
        array_unshift($images, $url);

        $news->update([
            'image_url' => $url,
            'images' => $images,
            'image_is_custom' => true,
        ]);

        if (is_string($previous) && $previous !== $url && ! in_array($previous, $images, true)) {
            $storedPath = MediaStorage::path($previous);

            if ($storedPath && str_starts_with($storedPath, 'news/')) {
                MediaStorage::delete($storedPath);
            }
        }

        return back()->with('success', 'News image updated. It now shows on the site.');
    }

    public function refresh(NewsItem $news, NewsSourceReader $reader)
    {
        try {
            $payload = $reader->read($news->source_url);
        } catch (InvalidArgumentException|RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        $keptImage = (bool) $news->image_is_custom;
        $this->replaceFromSource($news, $payload);

        return back()->with('success', $keptImage
            ? 'Story refreshed. The image you set is still used on the site.'
            : 'Story and images refreshed from the source.');
    }

    public function destroy(NewsItem $news)
    {
        $news->delete();

        return back()->with('success', 'News removed from the homepage.');
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function replaceFromSource(NewsItem $news, array $payload): void
    {
        $keepImage = $news->image_is_custom ? $news->image_url : null;

        $news->deleteStoredImages(is_string($keepImage) ? $keepImage : null);

        if (is_string($keepImage) && $keepImage !== '') {
            $images = array_values(array_filter(
                $payload['images'] ?? [],
                fn ($image) => is_string($image) && $image !== '' && $image !== $keepImage
            ));
            array_unshift($images, $keepImage);
            $payload['image_url'] = $keepImage;
            $payload['images'] = $images;
        }

        $news->update($payload);
    }
}
