<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'category_id' => 'int',
        'name' => 'string',
        'type' => 'enum[App\Enums\ItemType]',
        'cost' => 'float',
        'selling_price' => '?float',
        'stock' => 'int',
        'min_stock' => 'int',
        'measure_unit' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class,
        'enum' => Cast\EnumCast::class,
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
