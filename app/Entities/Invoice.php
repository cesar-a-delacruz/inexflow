<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Invoice extends Entity
{
    protected $datamap = [];

    protected $dates = ['invoice_date', 'due_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'invoice_number' => 'string',
        'invoice_date' => 'datetime',
        'due_date' => '?datetime',
        'payment_status' => 'string',
        'payment_method' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'contact_id' => null,
        'invoice_number' => null,
        'invoice_date' => null,
        'due_date' => null,
        'payment_status' => 'paid',
        'payment_method' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
    public function getStatusDisplayName(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Pagada',
            'pending' => 'Pendiente',
            'overdue' => 'Atrasada',
            'cancelled' => 'Cancelada',
            '' => ''
        };
    }
    public function getMethodDisplayName(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Efectivo',
            'card' => 'Tarjeta de Débito/Crédito',
            'transfer' => 'Transferencia Bancaria',
            '' => ''
        };
    }
    public function getContactTypeDisplayName(): string
    {
        return match ($this->contact_type) {
            'customer' => 'Cliente',
            'provider' => 'Proveedor',
        };
    }
}
