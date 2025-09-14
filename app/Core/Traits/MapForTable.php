<?php

namespace App\Core\Traits;

use Illuminate\Support\Collection;

trait MapForTable
{
    /*
    |--------------------------------------------------------------------------
    | Map For Table
    |--------------------------------------------------------------------------
    | - Collection of DTOs lai map garera table ma display garna milne structured
    |   data banauxa.
    | - Each DTO ma `getDataForTable()` method call garxa.
    | - `getDataForTable()` le chai DTO lai table row (array) ko format ma
    |   transform garxa.
    | - `rawData` parameter pass garera DTO lai additional raw data pani
    |   access garna milcha (flexibility for custom mapping).
    | - Mainly table rendering (rows, columns) ko lagi uniform data structure
    |   return garna use huncha.
    | - Return type: Collection (mapped table rows).
    */
    public static function mapForTable(Collection $collection): Collection
    {
        return self::mapWith($collection, function ($dto, $rawData) {
            return $dto->getDataForTable($rawData);
        });
    }
}
