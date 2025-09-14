<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Service extends AuditableEntity
{

    protected $casts = [
        'id' => 'int',
        'business_id' => 'uuid',
        'name' => 'string',
        'type' => 'enum[App\Enums\ItemType]',
        'cost' => 'float',
        'selling_price' => '?float',
        'measure_unit_id' => 'int',
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
