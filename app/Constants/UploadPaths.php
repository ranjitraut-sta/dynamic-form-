<?php

namespace App\Constants;

class UploadPaths
{
    public const PATHS = [
        'PROFILE_IMAGE_PATH' => [
            'path' => 'uploads/profile/images/',
            'prefix' => 'image'
        ],
    ];

    /**
     * Return all paths
     */
    public static function getPaths(): array
    {
        return self::PATHS;
    }

    /**
     * Return specific path by key
     */
    public static function getPath(string $key): ?array
    {
        return self::PATHS[$key] ?? null;
    }
}
