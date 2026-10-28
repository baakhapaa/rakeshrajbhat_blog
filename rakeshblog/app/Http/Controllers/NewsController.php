<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Models\Setting;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = NewsItem::query()
            ->where('is_active', true)
            ->latestFirst()
            ->get();
        $newsContent = Setting::getNewsContent();

        return view('news.index', compact('newsItems', 'newsContent'));
    }

    public function detail(NewsItem $newsItem)
    {
        if (! $newsItem->is_active) {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $newsItem->title,
                'excerpt' => $newsItem->excerpt,
                'content' => $newsItem->content,
                'image_url' => $newsItem->image_url,
                'images' => array_values(array_filter($newsItem->images ?? [])),
                'source_url' => $newsItem->source_url,
                'source_name' => $newsItem->source_name,
                'published_at' => optional($newsItem->published_at)->toIso8601String(),
            ],
        ]);
    }
}
