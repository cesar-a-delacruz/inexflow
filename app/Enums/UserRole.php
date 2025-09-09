<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum UserRole: string implements Displayable
{
    use DisplayableTrait;

    case Admin = 'admin';
    case Businessman = 'businessman';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'admin' => 'Admin',
            'businessman' => 'Empresario',
        };
    }

    public static function getDefault(): string
    {
        return self::Businessman->value;
    }
}
