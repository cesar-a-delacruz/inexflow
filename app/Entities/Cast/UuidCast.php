<?php

namespace App\Entities\Casts;

use CodeIgniter\Entity\Cast\BaseCast;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use InvalidArgumentException;

class UuidCast extends BaseCast
{
    /**
     * Convierte el valor binario de la DB a objeto UuidInterface
     * SE EJECUTA: Al leer de la base de datos
     */
    public static function get($value, array $params = []): ?UuidInterface
    {
        if ($value === null) {
            return null;
        }

        // Si ya es UuidInterface, devolverla
        if ($value instanceof UuidInterface) {
            return $value;
        }

        // Si es string UUID válido (36 caracteres) 
        if (is_string($value) && strlen($value) === 36 && Uuid::isValid($value)) {
            return Uuid::fromString($value);
        }

        // Si es binario (16 bytes) - ESTO ES LO IMPORTANTE
        if (is_string($value) && strlen($value) === 16) {
            try {
                return Uuid::fromBytes($value); // ← Convierte binario → UuidInterface
            } catch (InvalidArgumentException $e) {
                log_message('error', 'Error converting binary to UUID: ' . $e->getMessage());
                return null;
            }
        }

        log_message('error', 'Invalid UUID value: ' . print_r($value, true));
        return null;
    }

    /**
     * Convierte el objeto UuidInterface a binario para la DB
     * SE EJECUTA: Al escribir a la base de datos
     */
    public static function set($value, array $params = []): ?string
    {
        if ($value === null) {
            return null;
        }

        // Si ya es binario (16 bytes), devolverlo
        if (is_string($value) && strlen($value) === 16) {
            return $value;
        }

        // Si es string UUID válido
        if (is_string($value) && Uuid::isValid($value)) {
            return Uuid::fromString($value)->getBytes(); // ← String → binario
        }

        // Si es UuidInterface - ESTO ES LO IMPORTANTE  
        if ($value instanceof UuidInterface) {
            return $value->getBytes(); // ← UuidInterface → binario
        }

        log_message('error', 'Invalid UUID value for DB storage: ' . print_r($value, true));
        return null;
    }
}
