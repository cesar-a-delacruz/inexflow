<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum ServiceType: string implements Displayable
{
    use DisplayableTrait;

    case Expense = 'expense';
    case Income = 'income';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'expense' => 'Gasto',
            'income' => 'Ingreso',
        };
    }
    public static function getDefault(): string
    {
        return self::Expense->value;
    }
}
