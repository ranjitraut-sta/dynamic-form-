<?php

namespace App\Core\Traits;

use Illuminate\Support\Collection;

trait SelectOptionTransformable
{
    /*
    |--------------------------------------------------------------------------
    | Select Option Transformable
    |--------------------------------------------------------------------------
    | - Collection of DTOs lai map garera select option ko lagi formatted data
    |   banauxa.
    | - Default case ma each DTO ko `getDataForSelectOption()` method call garxa.
    | - Yadi custom callable function diyeko cha bhane, tesai anusar mapping garxa.
    | - Mainly dropdown, select input haru ma label-value pair banauxa.
    | - Return type: Collection (mapped result haru sanga).
    */
    public static function transformForSelectOption(Collection $collection, ?callable $customCallback = null): Collection
    {
       return $collection->map(function ($dto) use ($customCallback) {
            return $customCallback ? $customCallback($dto) : $dto->getDataForSelectOption();
        });
    }
}
