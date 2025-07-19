<?php

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

if (!function_exists('uuid_to_bytes')) {
    /**
     * Convierte cualquier formato UUID válido a bytes (binario)
     * 
     * @param UuidInterface|string $value UUID en cualquier formato válido
     * @return string UUID en formato binario (16 bytes)
     * @throws InvalidArgumentException
     */
    function uuid_to_bytes($value): string
    {
        if ($value instanceof UuidInterface) {
            return $value->getBytes();
        }

        if (is_string($value)) {
            if (strlen($value) === 36 && Uuid::isValid($value)) {
                return Uuid::fromString($value)->getBytes();
            }

            if (strlen($value) === 16) {
                return $value; // Ya está en formato bytes
            }
        }

        throw new InvalidArgumentException('Invalid UUID format');
    }
}

if (!function_exists('uuid_to_string')) {
    /**
     * Convierte cualquier formato UUID válido a string (hexadecimal)
     * 
     * @param UuidInterface|string $value UUID en cualquier formato válido
     * @return string UUID en formato string (36 caracteres)
     * @throws InvalidArgumentException
     */
    function uuid_to_string($value): string
    {
        if ($value instanceof UuidInterface) {
            return $value->toString();
        }

        if (is_string($value)) {
            if (strlen($value) === 36 && Uuid::isValid($value)) {
                return $value; // Ya está en formato string
            }

            if (strlen($value) === 16) {
                return Uuid::fromBytes($value)->toString();
            }
        }

        throw new InvalidArgumentException('Invalid UUID format');
    }
}

if (!function_exists('uuid_to_object')) {
    /**
     * Convierte cualquier formato UUID válido a objeto UuidInterface
     * 
     * @param UuidInterface|string $value UUID en cualquier formato válido
     * @return UuidInterface
     * @throws InvalidArgumentException
     */
    function uuid_to_object($value): UuidInterface
    {
        if ($value instanceof UuidInterface) {
            return $value;
        }

        if (is_string($value)) {
            if (strlen($value) === 36 && Uuid::isValid($value)) {
                return Uuid::fromString($value);
            }

            if (strlen($value) === 16) {
                return Uuid::fromBytes($value);
            }
        }

        throw new InvalidArgumentException('Invalid UUID format');
    }
}
