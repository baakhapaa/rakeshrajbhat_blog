<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaStorage
{
    /**
     * Convert stored URLs and legacy absolute filesystem paths to an object key.
     */
    public static function path(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $path = parse_url($value, PHP_URL_PATH) ?: $value;
        $path = str_replace('\\', '/', $path);

        foreach (['/storage/app/public/', '/storage/'] as $marker) {
            $position = strpos($path, $marker);
            if ($position !== false) {
                $path = substr($path, $position + strlen($marker));
                break;
            }
        }

        $path = ltrim($path, '/');
        $path = preg_replace('#^storage/app/public/#', '', $path);
        $path = preg_replace('#^storage/#', '', $path);

        if (!$path || str_starts_with($path, '../') || $path === '..') {
            return null;
        }

        return $path;
    }

    /**
     * Delete media without allowing a stale path or remote storage outage to
     * break an otherwise valid admin update.
     */
    public static function delete(?string $value): void
    {
        $path = self::path($value);
        if (!$path) {
            return;
        }

        try {
            Storage::disk('media')->delete($path);
        } catch (\Throwable $exception) {
            Log::warning('Unable to delete media file.', [
                'path' => $path,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
