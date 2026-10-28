<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use App\Models\Setting;
use App\Services\NewsSourceReader;
use Illuminate\Http\Request;
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
            $existing->deleteStoredImages();
            $existing->update($payload);

            return back()->with('success', 'That link was already added, so the story and images were refreshed.');
        }

        NewsItem::query()->create($payload);

        return back()->with('success', 'News added. It is now on the homepage.');
    }

    public function refresh(NewsItem $news, NewsSourceReader $reader)
    {
        try {
            $payload = $reader->read($news->source_url);
        } catch (InvalidArgumentException|RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        $news->deleteStoredImages();
        $news->update($payload);

        return back()->with('success', 'Story and images refreshed from the source.');
    }

    public function destroy(NewsItem $news)
    {
        $news->delete();

        return back()->with('success', 'News removed from the homepage.');
    }
}
