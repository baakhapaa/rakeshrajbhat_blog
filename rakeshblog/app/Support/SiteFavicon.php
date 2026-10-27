<?php

namespace App\Support;

use App\Models\Setting;

class SiteFavicon
{
    /**
     * Write the configured favicon to public/favicon.ico and public/favicon.png
     * so every page can show it, including the browser's default /favicon.ico request.
     */
    public static function publish(?string $source = null): bool
    {
        $source = $source ?: Setting::getValue('site_favicon');
        if (! is_string($source) || $source === '') {
            return false;
        }

        $bytes = self::read($source);
        if ($bytes === null) {
            return false;
        }

        $image = @imagecreatefromstring($bytes);
        if ($image === false) {
            return false;
        }

        $size = 32;
        $canvas = imagecreatetruecolor($size, $size);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $size, $size, $transparent);
        imagealphablending($canvas, true);
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $size, $size, imagesx($image), imagesy($image));
        imagedestroy($image);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);

        imagepng($canvas, public_path('favicon.png'));
        file_put_contents(public_path('favicon.ico'), self::toIco($canvas));
        imagedestroy($canvas);

        return is_file(public_path('favicon.ico')) && filesize(public_path('favicon.ico')) > 0;
    }

    private static function read(string $source): ?string
    {
        if (is_file($source)) {
            $bytes = file_get_contents($source);

            return $bytes === false ? null : $bytes;
        }

        if (! filter_var($source, FILTER_VALIDATE_URL)) {
            return null;
        }

        $context = stream_context_create([
            'http' => ['timeout' => 8],
            'https' => ['timeout' => 8],
        ]);
        $bytes = @file_get_contents($source, false, $context);

        return $bytes === false ? null : $bytes;
    }

    private static function toIco(\GdImage $image): string
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $xor = '';

        for ($y = $height - 1; $y >= 0; $y--) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($image, $x, $y);
                $alpha = ($color >> 24) & 0x7F;
                $red = ($color >> 16) & 0xFF;
                $green = ($color >> 8) & 0xFF;
                $blue = $color & 0xFF;
                $icoAlpha = 255 - (int) round($alpha * 255 / 127);
                $xor .= pack('C4', $blue, $green, $red, $icoAlpha);
            }
        }

        $andRow = (int) (ceil($width / 32) * 4);
        $and = str_repeat("\x00", $andRow * $height);
        $bitmap = pack('VVVvvVVVVVV', 40, $width, $height * 2, 1, 32, 0, strlen($xor) + strlen($and), 0, 0, 0, 0).$xor.$and;
        $entry = pack('CCCCvvVV', $width >= 256 ? 0 : $width, $height >= 256 ? 0 : $height, 0, 0, 1, 32, strlen($bitmap), 22);

        return pack('vvv', 0, 1, 1).$entry.$bitmap;
    }
}
