<?php

namespace App\Enums;

enum GoodsReceiptStatus: string
{
    case DRAFT = 'DRAFT';
    case CONFIRMED = 'CONFIRMED';
    case RECEIVED = 'RECEIVED';
    case CANCELLED = 'CANCELLED';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'DRAFT',
            self::CONFIRMED => 'CONFIRMED',
            self::RECEIVED => 'RECEIVED',
            self::CANCELLED => 'CANCELLED',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
