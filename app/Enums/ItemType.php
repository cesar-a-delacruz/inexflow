<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum ItemType: string implements Displayable
{
    use DisplayableTrait;

    case Service = 'service';
    case Product = 'product';
    case Ingredients = 'ingredients';
    case Supplies = 'supplies';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'service' => 'Servicio',
            'product' => 'Producto',
            'ingredients' => 'Ingrediente',
            'supplies' => 'Suplemento',
        };
    }
}
