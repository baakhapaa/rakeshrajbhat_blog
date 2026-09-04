<?php

$mediaDriver = env('MEDIA_DISK_DRIVER') ?: 'local';
$spacesRegion = env('DO_SPACES_REGION', 'nyc3');
$spacesEndpoint = env('DO_SPACES_ENDPOINT');

// Spaces writes must use the regional API endpoint, not the CDN hostname.
if ($spacesEndpoint && str_contains($spacesEndpoint, '.cdn.digitaloceanspaces.com')) {
    $spacesEndpoint = 'https://'.$spacesRegion.'.digitaloceanspaces.com';
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'media' => [
            // Empty environment values must not override the local fallback.
            'driver' => $mediaDriver,
            'root' => $mediaDriver === 's3'
                ? (env('DO_SPACES_ROOT') ?: '')
                : storage_path('app/public'),
            'url' => env('DO_SPACES_CDN_URL') ?: rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => $spacesRegion,
            'bucket' => env('DO_SPACES_BUCKET'),
            'endpoint' => $spacesEndpoint ?: 'https://'.$spacesRegion.'.digitaloceanspaces.com',
            'use_path_style_endpoint' => false,
            'throw' => true,
            'report' => true,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
