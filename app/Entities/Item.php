<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'category_id' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'cost' => 'float',
        'selling_price' => 'float',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'measure_unit' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Muestra el tipo de item en español */
    public function displayType(): string
    {
        return match ($this->type) {
            'service' => 'Servicio',
            'product' => 'Producto  ',
        };
    }
    
    /** Muestra el tipo de categoría en español (cuando se hace join con categoría) */
    public function displayCategoryType(): string
    {
        return match ($this->category_type) {
            'income' => 'Ingreso',
            'expense' => 'Gasto',
        };
    }

    /** Muestra propiedades si tienen valor  */
    public function displayProperty(string $property): string
    {
        return $this->{$property} ? $this->{$property} : 'No Aplica';
    }

    /** Muestra propiedades (monetarias) si tienen valor */
    public function displayMoney(string $money): string
    {
        return $this->{$money} ? '$'.number_format($this->{$money}, 2) : 'No Aplica';
    }
}
