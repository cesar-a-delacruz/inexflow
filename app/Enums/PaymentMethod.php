<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum PaymentMethod: string implements Displayable
{
    use DisplayableTrait;

    case Cash = 'cash';
    case Card = 'card';
    case Transfer = 'transfer';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'cash' => 'dinero',
            'card' => 'Tarjeta',
            'transfer' => 'Transferencia',
        };
    }

    public static function getDefault(): string
    {
        return self::Cash->value;
    }
}
