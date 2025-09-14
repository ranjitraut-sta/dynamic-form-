<?php

namespace App\Enum;
enum StatusEnum: int
{
    case Active = 1;
    case Inactive = 0;

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }

    public static function list(): array
    {
        return array_map(
            fn($status) => ['id' => $status->value, 'name' => $status->label()],
            self::cases()
        );
    }
}
