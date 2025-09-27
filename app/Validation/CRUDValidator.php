<?php

namespace App\Validation;

use CodeIgniter\Entity\Entity;

/**
 * @template T of Entity
 */
abstract class CRUDValidator
{
    /**  
     * Se usa para validar los datos de creacion de un nuevo elemento
     * @var array<string,array{'rules':string,'errors':array<string,string>}> $create */
    public array $create;
    /** 
     * Se usa para validar los datos de creacion de eliminacion de un elemento
     *  @var array<string,array{'rules':string,'errors':array<string,string>}> $delete */
    public array $delete;
    /**  
     * Se usa para validar los datos de actualizacion de un elemento
     * @var array<string,array{'rules':string,'errors':array<string,string>}> $update */
    public array $update;
}
