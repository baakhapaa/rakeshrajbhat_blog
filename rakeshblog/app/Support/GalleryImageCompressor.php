<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use RuntimeException;

class GalleryImageCompressor
{
    public const MAX_BYTES = 8096 * 1024;

    public static function exceedsLimit(UploadedFile $file): bool
    {
        $size = $file->getSize();

        return $size !== false && $size > self::MAX_BYTES;
    }

    /**
     * Re-encode an oversized photograph as a JPEG under 8096 KB.
     */
    public static function compress(UploadedFile $file): string
    {
        if (! function_exists('imagecreatetruecolor')) {
            throw new RuntimeException('Image compression is unavailable on this server.');
        }

        $currentLimit = ini_get('memory_limit');
        if (self::memoryToBytes($currentLimit) < 512 * 1024 * 1024) {
            ini_set('memory_limit', '512M');
        }

        $path = $file->getRealPath();
        $info = @getimagesize($path);
        if (! $info) {
            throw new RuntimeException('One photograph could not be read, so it was not uploaded.');
        }

        $decodedBytes = (int) $info[0] * (int) $info[1] * 4;
        if ($decodedBytes > 220 * 1024 * 1024) {
            throw new RuntimeException('One photograph is too large to compress. Choose a smaller image and try again.');
        }

        $image = self::load($path, (string) $file->getMimeType());
        if (! $image) {
            throw new RuntimeException('One photograph could not be read, so it was not uploaded.');
        }

        $image = self::applyOrientation($image, $path, (string) $file->getMimeType());
        $image = self::flatten($image);

        $width = imagesx($image);
        $height = imagesy($image);
        if (max($width, $height) > 4096) {
            $image = self::scale($image, 4096 / max($width, $height));
        }

        $temporary = tempnam(sys_get_temp_dir(), 'gallery');
        $destination = $temporary.'.jpg';
        @unlink($temporary);
        $saved = false;
        $qualities = [85, 75, 65, 55, 45, 35, 28];

        for ($attempt = 0; $attempt < 8; $attempt++) {
            foreach ($qualities as $quality) {
                imagejpeg($image, $destination, $quality);
                clearstatcache(true, $destination);
                if (is_file($destination) && filesize($destination) <= self::MAX_BYTES) {
                    $saved = true;
                    break 2;
                }
            }

            if (max(imagesx($image), imagesy($image)) <= 1600) {
                break;
            }

            $image = self::scale($image, 0.8);
        }

        imagedestroy($image);

        clearstatcache(true, $destination);
        if (! $saved || ! is_file($destination) || filesize($destination) > self::MAX_BYTES) {
            @unlink($destination);
            throw new RuntimeException('One photograph could not be compressed under 8096 KB.');
        }

        return $destination;
    }

    private static function load(string $path, string $mime): \GdImage|false
    {
        $image = match ($mime) {
            'image/jpeg', 'image/jpg', 'image/pjpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            'image/gif' => @imagecreatefromgif($path),
            default => @imagecreatefromstring((string) file_get_contents($path)),
        };

        return $image instanceof \GdImage ? $image : false;
    }

    private static function applyOrientation(\GdImage $image, string $path, string $mime): \GdImage
    {
        if (! function_exists('exif_read_data') || ! in_array($mime, ['image/jpeg', 'image/jpg', 'image/pjpeg'], true)) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = (int) ($exif['Orientation'] ?? 0);
        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => false,
        };

        if ($rotated instanceof \GdImage) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }

    private static function flatten(\GdImage $image): \GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $flat = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($flat, 255, 255, 255);
        imagefilledrectangle($flat, 0, 0, $width, $height, $white);
        imagecopy($flat, $image, 0, 0, 0, 0, $width, $height);
        imagedestroy($image);

        return $flat;
    }

    private static function scale(\GdImage $image, float $ratio): \GdImage
    {
        $width = max(1, (int) round(imagesx($image) * $ratio));
        $height = max(1, (int) round(imagesy($image) * $ratio));
        $scaled = imagecreatetruecolor($width, $height);
        imagecopyresampled($scaled, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
        imagedestroy($image);

        return $scaled;
    }

    private static function memoryToBytes(string|false $limit): int
    {
        if ($limit === false || $limit === '' || $limit === '-1') {
            return PHP_INT_MAX;
        }

        $unit = strtolower(substr($limit, -1));
        $value = (int) $limit;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => (int) $limit,
        };
    }
}
