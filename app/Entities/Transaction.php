<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{
    protected $dates = ['due_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'number' => 'string',
        'due_date' => '?datetime',
        'payment_status' => 'string',
        'payment_method' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Muestra el estado de pago de una transacción en español */
    public function displayPaymentStatus(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Pagada',
            'pending' => 'Pendiente',
            'overdue' => 'Atrasada',
            'cancelled' => 'Cancelada',
            '' => ''
        };
    }
    
    /** Muestra el método de pago de una transacción en español */
    public function displayPaymentMethod(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Efectivo',
            'card' => 'Tarjeta de Débito/Crédito',
            'transfer' => 'Transferencia Bancaria',
            '' => ''
        };
    }

    /** Muestra el tipo de contacto de una transacción en español (cuando se hace join con contacto) */
    public function displayContactType(): string
    {
        return match ($this->contact_type) {
            'customer' => 'Cliente',
            'provider' => 'Proveedor',
            null => 'No Aplica'
        };
    }

    /** Muestra el nombre del contacto de una transacción (cuando se hace join con contacto) */
    public function displayContactName(): string
    {
        return $this->contact_name ? $this->contact_name : 'Anónimo';
    }
}
