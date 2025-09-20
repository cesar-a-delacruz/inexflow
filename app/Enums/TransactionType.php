<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum TransactionType: string implements Displayable
{
    use DisplayableTrait;
/**
     * Gastos
     */
    case Expense = 'expense';
/**
     * Ingreso
     */
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
