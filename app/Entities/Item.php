<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'type' => 'enum[App\Enums\ItemType]',
        'cost' => 'float',
        'selling_price' => '?float',
        'stock' => 'int',
        'min_stock' => 'int',
        'measure_unit_id' => 'int',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];

    protected $castHandlers = [
        'enum' => Cast\EnumCast::class,
        'uuid' => Cast\UuidCast::class,
    ];

    /** Muestra propiedades si tienen valor  */
    public function displayProperty(string $property): string
    {
        return $this->{$property} ?? '--';
    }

    /** Muestra propiedades (monetarias) si tienen valor */
    public function displayCost(): string
    {
        return number_to_currency($this->cost, 'PAB', 'es_PA', 2);
    }
    /** Muestra propiedades (monetarias) si tienen valor */
    public function displaySellingPrice(): string
    {
        return !!$this->selling_price ? number_to_currency($this->selling_price, 'PAB', 'es_PA', 2) : '--';
    }
}
