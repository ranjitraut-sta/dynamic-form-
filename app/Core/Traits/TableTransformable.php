<?php

namespace App\Core\Traits;

use Illuminate\Support\Collection;

trait TableTransformable
{
     /*
    |--------------------------------------------------------------------------
    | Table Transformable
    |--------------------------------------------------------------------------
    | - Collection of DTOs lai map garera table ma display garna milne formatted
    |   array banauxa.
    | - Default case ma each DTO ko `getDataForTable()` method call garxa.
    | - Yadi custom callable function diyeko cha bhane, tesai anusar mapping garxa.
    | - Mainly table rendering (columns, rows) ko lagi structured data banauxa.
    | - Return type: Collection (mapped result haru sanga).
    */
    public static function transformForTable(Collection $collection, ?callable $customCallback = null): Collection
    {
        return $collection->map(function ($dto) use ($customCallback) {
            return $customCallback ? $customCallback($dto) : $dto->getDataForTable();
        });
    }
}
