<?php

namespace App\Core\Helpers;

use App\Constants\UploadPaths;

class FilePathHelper
{
   /*
    |--------------------------------------------------------------------------
    | File Path Helper
    |--------------------------------------------------------------------------
    | - Given a filename and type, returns the full URL to access the file.
    | - `$filename` : Name of the file. If null or empty, returns empty string.
    | - `$type` : Type of file (e.g., 'profile', 'document', 'default'), used to fetch
    |   path configuration from UploadPaths constant.
    | - Checks if configured path exists. If not, returns empty string.
    | - Adds 'storage/' prefix to path if not already present.
    | - Uses Laravel `asset()` helper to generate full URL.
    | - Return type: string (full URL or empty string).
    |
    | Usage:
    |   FilePathHelper::getUrl('avatar.jpg', 'profile');
    |   → returns URL like: https://example.com/storage/profile/avatar.jpg
    */
    public static function getUrl(?string $filename, string $type = 'default'): string
    {
        if (!$filename) {
            return '';
        }
        $pathConfig = UploadPaths::getPath($type);

        if (!$pathConfig) {
            return '';
        }
        $path = $pathConfig['path'] ?? '';
        // Add storage prefix if not already present
        if (!str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }
        return asset($path . $filename);
    }
}
