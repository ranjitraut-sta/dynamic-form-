<?php

namespace App\Enum;

enum GenderEnum: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Male',
            self::Female => 'Female',
            self::Other => 'Other',
        };
    }

    public static function list(): array
    {
        return array_map(
            fn($gender) => ['id' => $gender->value, 'name' => $gender->label()],
            self::cases()
        );
    }
}
