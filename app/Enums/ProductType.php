<?php

namespace App\Enums;

enum ProductType: string
{
    case RAW = 'RAW';
    case FINISH = 'FINISH';
    case SERVICE = 'SERVICE';

    public function label(): string
    {
        return match ($this) {
            self::RAW => 'RAW MATERIAL',
            self::FINISH => 'FINISHED GOOD',
            self::SERVICE => 'SERVICE',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
