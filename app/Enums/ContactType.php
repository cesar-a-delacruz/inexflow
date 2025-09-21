<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum ContactType: string implements Displayable
{
    use DisplayableTrait;

    case Customer = 'customer';
    case Provider = 'provider';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'customer' => 'Cliente',
            'provider' => 'Proveedor',
        };
    }

    public static function getDefault(): string
    {
        return self::Customer->value;
    }
}
