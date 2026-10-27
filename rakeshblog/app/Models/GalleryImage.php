<?php

namespace App\Models;

use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
            $host = parse_url($this->path, PHP_URL_HOST);

            if (! $host || ! str_ends_with($host, '.digitaloceanspaces.com')) {
                return $this->path;
            }

            $mediaPath = MediaStorage::path($this->path);

            return $mediaPath ? $this->mediaUrl($mediaPath) : $this->path;
        }

        return $this->mediaUrl($this->path);
    }

    public function deleteStoredFile(): void
    {
        MediaStorage::delete($this->path);
    }

    private function mediaUrl(string $path): string
    {
        $disk = config('filesystems.disks.media.driver') ? 'media' : 'public';

        return Storage::disk($disk)->url($path);
    }
}
