<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    public const CATEGORIES = [
        'community' => ['filter' => 'Community', 'badge' => 'Community Updates'],
        'project' => ['filter' => 'Project News', 'badge' => 'Project News'],
        'media' => ['filter' => 'In the Media', 'badge' => 'In the Media'],
    ];

    protected $fillable = [
        'source_url',
        'source_hash',
        'source_name',
        'category',
        'title',
        'excerpt',
        'content',
        'image_url',
        'image_is_custom',
        'images',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'image_is_custom' => 'boolean',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function badgeLabel(): string
    {
        $category = self::CATEGORIES[$this->category] ?? null;

        if ($category) {
            return $category['badge'];
        }

        return $this->source_name ?: 'News';
    }

    public function displayDate(): ?string
    {
        $date = $this->published_at ?? $this->created_at;

        return $date ? mb_strtoupper($date->format('M d, Y')) : null;
    }

    public function scopeLatestFirst($query)
    {
        return $query
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->orderByDesc('id');
    }

    protected static function booted(): void
    {
        static::deleting(function (NewsItem $item) {
            $item->deleteStoredImages();
        });
    }

    public function deleteStoredImages(?string $keepUrl = null): void
    {
        $urls = array_merge([$this->image_url], $this->images ?? []);
        $keepPath = MediaStorage::path($keepUrl);

        foreach ($urls as $url) {
            $path = MediaStorage::path(is_string($url) ? $url : null);

            if (! $path || ! str_starts_with($path, 'news/')) {
                continue;
            }

            if ($keepPath && $path === $keepPath) {
                continue;
            }

            MediaStorage::delete($path);
        }
    }
}
