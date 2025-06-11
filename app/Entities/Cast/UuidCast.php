<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use InvalidArgumentException;

class UuidCast extends BaseCast
{
    /**
     * Inserta el dato en la basa de datos, en base al objeto
     */
    public static function set($value, array $params = [])
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value->getBytes();
        }

        if (is_string($value) && strlen($value) === 36 && Uuid::isValid($value)) {
            return Uuid::fromString($value)->getBytes();
        }

        if (is_string($value) && strlen($value) === 16) {
            return $value;
        }
        return null;
    }

    /**
     * Obtiene datos de la Base de Datos;
     */
    public static function get($value, array $params = [])
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        if (is_string($value) && strlen($value) === 36 && Uuid::isValid($value)) {
            return Uuid::fromString($value);
        }

        if (is_string($value) && strlen($value) === 16) {
            return Uuid::fromBytes($value);
        }

        return null;
    }
}
