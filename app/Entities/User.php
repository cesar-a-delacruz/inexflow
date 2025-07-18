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

    public function setPassword(string $password)
    {
        $this->attributes['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->attributes['password_hash'] ?? null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getPasswordHash());
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function displayRole(): string
    {
        return match ($this->role) {
            'admin' => 'Administrador',
            'businessman' => 'Empresario'
        };
    }

    public function displayIsActive(): string
    {
        return match ($this->is_active) {
            true => 'Activo',
            false => 'Inactivo'
        };
    }
}
