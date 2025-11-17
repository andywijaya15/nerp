<?php

namespace App\Enums;

enum SupplierType: string
{
    case LOCAL = 'LOCAL';
    case IMPORT = 'IMPORT';
    case SERVICE = 'SERVICE';

    public function label(): string
    {
        return match ($this) {
            self::LOCAL => 'LOCAL',
            self::IMPORT => 'IMPORT',
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
