<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum ItemType: string implements Displayable
{
    use DisplayableTrait;

    case Product = 'product';
    case Supply = 'supply';
    // case Supplies = 'supplies';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'product' => 'Producto',
            'supply' => 'Suministro',
        };
    }

    public static function getDefault(): string
    {
        return self::Product->value;
    }
}
