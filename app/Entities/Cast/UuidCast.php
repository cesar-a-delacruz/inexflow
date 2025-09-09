<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class UuidCast extends BaseCast
{
    /**
     * Inserta el dato en la basa de datos, en base al objeto
     */
    public static function set($value, array $params = [])
    {
        if ($value === null) return null;

        return uuid_to_bytes($value);
    }

    /**
     * Obtiene datos de la Base de Datos;
     */
    public static function get($value, array $params = [])
    {
        if ($value === null) return null;

        return uuid_to_object($value);
    }
}
