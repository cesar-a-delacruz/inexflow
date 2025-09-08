<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;
use InvalidArgumentException;

class EnumCast extends BaseCast
{
    public static function get($value, array $params = [])
    {
        $enumClass = $params[0] ?? null;
        if (!$enumClass || !enum_exists($enumClass)) {
            throw new InvalidArgumentException("Enum inválido: {$enumClass}");
        }

        return $enumClass::from($value); // convierte string de BD → Enum PHP
    }

    public static function set($value, array $params = [])
    {
        if ($value instanceof \BackedEnum) {
            return $value->value; // Enum PHP → string para BD
        }

        return $value; // fallback
    }
}
