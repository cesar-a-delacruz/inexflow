<?php

namespace App\Enums;

use App\Enums\Observable\Displayable;
use App\Enums\Observable\DisplayableTrait;

enum PaymentStatus: string implements Displayable
{
    use DisplayableTrait;

    case Paid = 'paid';
    case Pending = 'pending';
    case Overdue = 'overdue';
    case Cancelled = 'cancelled';

    public static function labelFromValue(string $value): string
    {
        return match ($value) {
            'paid' => 'Pagado',
            'pending' => 'Pendiente',
            'overdue' => 'otro',
            'cancelled' => 'Cancelado',
        };
    }

    public static function getDefault(): string
    {
        return self::Paid->value;
    }
}
