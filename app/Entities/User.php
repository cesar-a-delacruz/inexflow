<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'email' => 'string',
        'role' => 'string',
        'password_hash' => 'string',
        'business_id' => 'uuid',
        'is_active'   => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime'
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Guarda la contraseña encriptada del usuario */
    public function setPassword(string $password)
    {
        $this->attributes['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /** Obtiene la contraseña encriptada del usuario si tiene valor */
    public function getPasswordHash(): ?string
    {
        return $this->attributes['password_hash'] ?? null;
    }

    /** Verifica si una contraseña brindada coincide con la contraseña encriptada del usuario */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getPasswordHash());
    }

    /** Verifica si el usuario está activo */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /** Muestra el rol del usuario en español */
    public function displayRole(): string
    {
        return match ($this->role) {
            'admin' => 'Administrador',
            'businessman' => 'Empresario'
        };
    }

    /** Muestra el estado de actividad del usuario en español */
    public function displayIsActive(): string
    {
        return match ($this->is_active) {
            true => 'Activo',
            false => 'Inactivo'
        };
    }
}
