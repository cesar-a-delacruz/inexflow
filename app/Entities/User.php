<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    /**
     * Datos que pueden ser rellenados durante la creación de instancia
     */
    protected $datamap = [];

    /**
     * Define el tipo de datos para cada campo
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Campos que deben ser convertidos a tipos específicos
     */
    protected $casts = [
        'id'          => 'uuid',
        'business_id' => 'uuid',
        'is_active'   => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime'
    ];

    /**
     * Casts personalizados
     */
    protected $castHandlers = [
        'uuid' => \App\Entities\Casts\UuidCast::class
    ];

    /**
     * Campos que deben estar presentes
     */
    protected $attributes = [
        'role'      => 'businessman',
        'is_active' => true
    ];

    /**
     * Mutator para el password - asegura que siempre se hashee
     */
    public function setPassword(string $password)
    {
        $this->attributes['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Accessor para obtener el password hasheado
     */
    public function getPasswordHash(): ?string
    {
        return $this->attributes['password_hash'] ?? null;
    }

    /**
     * Método para verificar password
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getPasswordHash());
    }

    /**
     * Accessor para verificar si es admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor para verificar si es businessman
     */
    public function isBusinessman(): bool
    {
        return $this->role === 'businessman';
    }

    /**
     * Accessor para verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Accessor para verificar si está eliminado (soft delete)
     */
    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    /**
     * Método para obtener el nombre completo del rol
     */
    public function getRoleDisplayName(): string
    {
        return match ($this->role) {
            'admin' => 'Administrador',
            'businessman' => 'Empresario',
            default => ucfirst($this->role)
        };
    }

    /**
     * Método para generar un UUID antes de guardar
     */
    public function generateUuid(): self
    {
        if (empty($this->id)) {
            // Asignar directamente el objeto UuidInterface
            // El cast lo convertirá a binario automáticamente al guardar
            $this->id = \Ramsey\Uuid\Uuid::uuid4();
        }
        return $this;
    }

    /**
     * Accessor para obtener el ID como string
     */
    public function getIdAsString(): ?string
    {
        return $this->id ? $this->id->toString() : null;
    }

    /**
     * Accessor para obtener business_id como string
     */
    public function getBusinessIdAsString(): ?string
    {
        return $this->business_id ? $this->business_id->toString() : null;
    }
}
