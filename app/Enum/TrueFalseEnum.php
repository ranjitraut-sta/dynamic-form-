<?php

namespace App\Enum;

enum TrueFalseEnum: int
{
    case True = 1;
    case False = 0;

    public function label(): string
    {
        return match ($this) {
            self::True => 'True',
            self::False => 'False',
        };
    }

    public static function list(): array
    {
        return array_map(
            fn($item) => ['id' => $item->value, 'name' => $item->label()],
            self::cases()
        );
    }
}
