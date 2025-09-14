<?php

namespace App\Core\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SlugGeneratorService
{
    // SlugGeneratorService::generate('posts', 'My Title'); use like this
    public static function generate(string $table, string $title, string $slugColumn = 'slug'): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        $i = 1;
        while (DB::table($table)->where($slugColumn, $slug)->exists()) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
