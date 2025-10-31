<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Compression Settings
    |--------------------------------------------------------------------------
    |
    | These are the default settings used for image compression when no
    | specific settings are provided to the component methods.
    |
    */

    'default' => [
        'max_width' => 1920,
        'quality' => 80,
        'format' => 'webp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar Compression Settings
    |--------------------------------------------------------------------------
    |
    | Specific settings for avatar uploads, typically smaller and higher quality.
    |
    */

    'avatar' => [
        'max_width' => 400,
        'quality' => 85,
        'format' => 'webp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed MIME Types
    |--------------------------------------------------------------------------
    |
    | List of allowed image MIME types that can be processed by the plugin.
    |
    */

    'allowed_mime_types' => [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Settings
    |--------------------------------------------------------------------------
    |
    | Default storage disk and path for compressed images.
    |
    */

    'storage' => [
        'disk' => 'public',
        'path' => 'compressed-images',
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Settings to optimize performance during image processing.
    |
    */

    'performance' => [
        'memory_limit' => '256M',
        'max_execution_time' => 60,
    ],
];
