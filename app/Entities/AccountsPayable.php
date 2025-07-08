<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AccountsPayable extends Entity
{
    protected $datamap = [];

    protected $dates = ['due_date', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'transaction_id' => '?int',
        'invoice_number' => '?string',
        'description' => 'string',
        'original_amount' => 'decimal',
        'paid_amount' => 'decimal',
        'balance_due' => 'decimal',
        'due_date' => 'datetime',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'contact_id' => null,
        'transaction_id' => null,
        'invoice_number' => null,
        'description' => null,
        'original_amount' => null,
        'paid_amount' => 0.00,
        'balance_due' => null,
        'due_date' => null,
        'status' => 'pending',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /**
     * Verificar si la cuenta está vencida
     */
    public function isOverdue(): bool
    {
        return $this->due_date < date('Y-m-d') && $this->status !== 'paid';
    }

    /**
     * Verificar si la cuenta está pagada completamente
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid' || $this->balance_due <= 0;
    }

    /**
     * Calcular el porcentaje pagado
     */
    public function getPaymentPercentage(): float
    {
        if ($this->original_amount <= 0) {
            return 0;
        }

        return ($this->paid_amount / $this->original_amount) * 100;
    }

    /**
     * Obtener días vencidos
     */
    public function getDaysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $dueDate = new \DateTime($this->due_date);
        $today = new \DateTime();

        return $today->diff($dueDate)->days;
    }
}
