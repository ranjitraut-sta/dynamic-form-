<?php

namespace App\Core\DTOs;

use App\Core\Traits\SelectOptionTransformable;
use App\Core\Traits\TableTransformable;
use App\Core\Traits\mapForTable;
use Illuminate\Support\Collection;

abstract class BaseDto
{
    use TableTransformable;
    use SelectOptionTransformable;
    use mapForTable;
    /*
     |------------------------------------------------------------------
     | DTO __construct() Method Definition
     |------------------------------------------------------------------
     | - Constructor le associative array (key-value pair) input lincha.
     | - Array ko key haru class ko properties sanga milne ho bhane,
     |   tyo property ma value automatic assign garincha.
     | - Manual property assignment garna pardaina, code clean ra reusable bancha.
     | - Yo pattern le DTO banaunda boilerplate code ghatauchha.
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists(static::class, $key)) {
                $this->$key = $value;
            }
        }
    }

    /*
   |------------------------------------------------------------------
   | DTO fromArray() Method Definition
   |------------------------------------------------------------------
   | - Array bata DTO object banaucha.
   | - Constructor ma data pathaera property haru assign garincha.
   | - DTO ko factory method jasto kam garcha.
   */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /*
    |------------------------------------------------------------------
    | DTO toArray() Method Definition
    |------------------------------------------------------------------
    | - sabai DTO class haru le yo method avashya implement garnu parchha.
    | - yo method le DTO object lai array ma pariwartan garne kam garchha.
    | - yo fromArray() method ko ulto prakriya ho.
    */
    public function toArray(): array
    {
        return get_object_vars($this);
    }


    /*
    |------------------------------------------------------------------
    | DTO fromCollection() Method Definition
    |------------------------------------------------------------------
    | - Yo method le Laravel Collection (e.g., model list) ko sabai item haru lai
    |   DTO object ma convert garera naya Collection return garcha.
    | - Item array format ma cha bhane seedha array pathauncha.
    | - Item object format ma cha bhane, toArray() method call garera array ma convert garincha.
    | - Yo process le collection ko sabai elements lai DTO ma transform garna sahayog garcha.
    */
    public static function fromCollection(Collection $items): Collection
    {
        return $items->map(
            fn($item) => static::fromArray(
                is_array($item) ? $item : $item->toArray()
            )
        );
    }

    /*
     |------------------------------------------------------------------
     | DTO mapFor() Method Definition
     |------------------------------------------------------------------
     | - Yo method le Collection ko pratyek item lai DTO ma convert garcha.
     | - Tes pachi DTO ko diye ko method ($method) call garcha.
     | - Ani method ko sabai result haru ko Collection return garcha.
     | - Yo mainly frontend display ya table jasto format transformation kaam ma useful huncha.
     */
    public static function mapFor(Collection $items, string $method): Collection
    {
        return $items->map(function ($item) use ($method) {
            $dto = static::fromArray((array) (method_exists($item, 'toArray') ? $item->toArray() : $item));
            return $dto->{$method}();
        });
    }

    /*
    |------------------------------------------------------------------
    | DTO mapForSite() Method Definition
    |------------------------------------------------------------------
    | - Collection bhitra ka pratyek item lai array ma convert garcha.
    | - Tes pachi static class method ($method) lai call garcha tyo array sanga.
    | - Yo method mainly static transformation functions ma use huncha.
    | - Result haru ko naya Collection return garcha.
    | - Frontend presentation ya select option jasto data formatting ma helpful huncha.
    */
    public static function mapForSite(Collection $items, string $method): Collection
    {
        return $items->map(function ($item) use ($method) {
            return static::{$method}((array) $item);
        });
    }

    /*
    |------------------------------------------------------------------
    | DTO mapWith() Method Definition
    |------------------------------------------------------------------
    | - Collection ko pratyek item lai DTO object ma convert garcha.
    | - Conversion pachi, diyeko callback function lai call garcha.
    | - Callback function le DTO object ra original item dubaile access garna paunchha.
    | - Callback function ko result haru ko naya Collection return garcha.
    | - Custom transformation ra flexible processing ko lagi use garincha.
    */
    public static function mapWith(Collection $items, callable $callback): Collection
    {
        return $items->map(function ($item) use ($callback) {
            $dto = static::fromArray((array) (method_exists($item, 'toArray') ? $item->toArray() : $item));
            return $callback($dto, $item);
        });
    }
}
