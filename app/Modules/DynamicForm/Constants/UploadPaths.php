<?php

namespace App\Modules\DynamicForm\Constants;

class UploadPaths
{
    public const PATHS = [
        'THUMBNAIL' => [
            'path' => 'uploads/dynamicform/thumbnails',
            'prefix' => 'thumb',
        ],
        'DOCUMENTS' => [
            'path' => 'uploads/dynamicform/documents',
            'prefix' => 'doc',
        ],
    ];
}