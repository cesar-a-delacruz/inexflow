<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Entities\Cast\UuidCast;

abstract class AuditableEntity extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected bool|null $tenant;
    protected static array $date_casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];

    public function __construct()
    {

        // Si el hijo define $casts, se fusiona
        if (property_exists($this, 'casts')) {
            $this->casts = array_merge($this->casts, $this->date_casts);
        } else {
            $this->casts = $this->date_casts;
        }

        // Si el hijo define $tenant como true
        if (!!$this->tenant) {
            $this->casts['business_id'] = 'uuid';
            if (property_exists($this, 'castHandlers')) {
                $this->castHandlers['uuid'] = UuidCast::class;
            } else {
                $this->castHandlers = ['uuid' => UuidCast::class];
            }
        }

        parent::__construct();
    }
}
