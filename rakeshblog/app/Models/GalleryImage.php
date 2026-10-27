<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_collection_id',
        'path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function (GalleryImage $image) {
            $image->deleteStoredFile();
        });
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(GalleryCollection::class, 'gallery_collection_id');
    }

    public function getUrlAttribute(): ?string
    {
        if (! $this->path) {
            return null;
        }

        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        return Storage::disk('gallery')->url($this->path);
    }

    public function deleteStoredFile(): void
    {
        if (! $this->path || str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return;
        }

        try {
            Storage::disk('gallery')->delete($this->path);
        } catch (\Throwable $exception) {
            Log::warning('Unable to delete gallery image from Spaces.', [
                'path' => $this->path,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
