<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AccountsReceivable extends Entity
{
    protected $datamap = [];

    protected $dates = ['due_date', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'invoice_id' => 'uuid',
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
        'invoice_id' => null,
        'original_amount' => null,
        'paid_amount' => 0.00,
        'balance_due' => null,
        'due_date' => null,
        'status' => 'current',
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /**
     * Verificar si la cuenta está vencida
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || ($this->due_date && $this->due_date < date('Y-m-d'));
    }

    /**
     * Obtener días de vencimiento
     */
    public function getDaysOverdue(): int
    {
        if (!$this->due_date || $this->status === 'paid') {
            return 0;
        }

        $dueDate = new \DateTime($this->due_date);
        $today = new \DateTime();
        $diff = $today->diff($dueDate);

        return $diff->days * ($diff->invert ? 1 : -1);
    }

    /**
     * Calcular porcentaje pagado
     */
    public function getPaidPercentage(): float
    {
        if ($this->original_amount == 0) {
            return 0;
        }

        return ($this->paid_amount / $this->original_amount) * 100;
    }

    /**
     * Verificar si está completamente pagado
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid' || $this->balance_due <= 0;
    }
}
