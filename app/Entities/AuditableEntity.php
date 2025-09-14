<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

abstract class AuditableEntity extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected bool $tenants;
    protected array $date_casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];

    public function __construct(array|null $data)
    {
        parent::__construct($data);

        // Si el hijo define $casts, se fusiona
        if (property_exists($this, 'casts')) {
            $this->casts = array_merge($this->casts, $this->date_casts);
        } else {
            $this->casts = $this->date_casts;
        }
    }
}
