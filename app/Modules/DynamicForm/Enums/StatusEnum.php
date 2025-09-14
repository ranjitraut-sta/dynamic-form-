<?php

namespace App\Modules\DynamicForm\Enums;

enum StatusEnum: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired = 'expired';

    public function label(): string
    {
        return match($this) {
            self::Draft => 'Draft',
            self::Sent => 'Sent',
            self::Accepted => 'Accepted',
            self::Rejected => 'Rejected',
            self::Expired => 'Expired',
        };
    }

    public static function list(): array
    {
        return array_map(fn($status) => [
            'id' => $status->value,
            'name' => $status->label()
        ], self::cases());
    }
}