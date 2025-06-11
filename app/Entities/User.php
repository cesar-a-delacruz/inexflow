<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];

    protected $attributes = [
        'role'      => 'businessman',
        'is_active' => 1,
        'id' => null,
        'name' =>  null,
        'email' =>  null,
        'password' => null,
        'business_id' => null,
    ];

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
        return $this->attributes['password'] ?? null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getPasswordHash());
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBusinessman(): bool
    {
        return $this->role === 'businessman';
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    public function getRoleDisplayName(): string
    {
        return match ($this->role) {
            'admin' => 'Administrador',
            'businessman' => 'Empresario',
            default => ucfirst($this->role)
        };
    }

    public function getIdAsString(): ?string
    {
        return $this->id ? $this->id->toString() : null;
    }

    public function getBusinessIdAsString(): ?string
    {
        return $this->business_id ? $this->business_id->toString() : null;
    }
}
