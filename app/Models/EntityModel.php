<?php

namespace App\Models;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;

/**
 * @template T of Entity
 */
abstract class EntityModel extends Model
{
    /** @var class-string<T> */
    protected $returnType;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
}
