<?php

namespace App\Support;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class AboutVideo
{
    /**
     * Compress a portrait video for the About frame and grab a poster frame.
     *
     * @return array{url: string, poster: string}|null
     */
    public static function storeOptimized(string $sourcePath): ?array
    {
        if (! is_file($sourcePath)) {
            return null;
        }

        $videoBase = tempnam(sys_get_temp_dir(), 'aboutvid');
        $posterBase = tempnam(sys_get_temp_dir(), 'aboutposter');

        if ($videoBase === false || $posterBase === false) {
            return null;
        }

        $videoOut = $videoBase.'.mp4';
        $posterOut = $posterBase.'.jpg';

        $video = Process::timeout(180)->run([
            'ffmpeg',
            '-y',
            '-i',
            $sourcePath,
            '-map',
            '0:v:0',
            '-map',
            '0:a:0?',
            '-vf',
            "scale='min(720,iw)':-2",
            '-c:v',
            'libx264',
            '-preset',
            'veryfast',
            '-crf',
            '30',
            '-pix_fmt',
            'yuv420p',
            '-c:a',
            'aac',
            '-b:a',
            '64k',
            '-movflags',
            '+faststart',
            $videoOut,
        ]);

        if (! $video->successful() || ! is_file($videoOut) || filesize($videoOut) < 1000) {
            self::cleanup([$videoBase, $videoOut, $posterBase, $posterOut]);

            return null;
        }

        $poster = Process::timeout(60)->run([
            'ffmpeg',
            '-y',
            '-i',
            $videoOut,
            '-frames:v',
            '1',
            '-q:v',
            '5',
            $posterOut,
        ]);

        if (! $poster->successful() || ! is_file($posterOut)) {
            self::cleanup([$videoBase, $videoOut, $posterBase, $posterOut]);

            return null;
        }

        try {
            $videoPath = Storage::disk('media')->putFile('about', new File($videoOut));
            $posterPath = Storage::disk('media')->putFile('about', new File($posterOut));
        } finally {
            self::cleanup([$videoBase, $videoOut, $posterBase, $posterOut]);
        }

        if (! $videoPath || ! $posterPath) {
            return null;
        }

        return [
            'url' => Storage::disk('media')->url($videoPath),
            'poster' => Storage::disk('media')->url($posterPath),
        ];
    }

    /**
     * @param  array<int, string>  $paths
     */
    private static function cleanup(array $paths): void
    {
        foreach ($paths as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }
}
