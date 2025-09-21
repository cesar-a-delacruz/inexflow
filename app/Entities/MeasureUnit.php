<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MeasureUnit extends Entity
{

    protected $casts = [
        'id' => 'int',
        'value' => 'string',
    ];
}
