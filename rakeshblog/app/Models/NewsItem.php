<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = [
        'source_url',
        'source_hash',
        'source_name',
        'title',
        'excerpt',
        'content',
        'image_url',
        'images',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

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

    public function deleteStoredImages(): void
    {
        $urls = array_merge([$this->image_url], $this->images ?? []);

        foreach ($urls as $url) {
            $path = MediaStorage::path(is_string($url) ? $url : null);

            if ($path && str_starts_with($path, 'news/')) {
                MediaStorage::delete($path);
            }
        }
    }
}
