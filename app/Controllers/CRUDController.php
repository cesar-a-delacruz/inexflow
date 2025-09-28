<?php

namespace App\Controllers;

use App\Validation\CRUDValidator;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;

/**
 * @template E of Entity
 * @template M of Model<E>
 * @template V of CRUDValidator<E>
 * @extends BaseController
 */
abstract class CRUDController extends BaseController
{

    /** @var M */
    protected Model $model;

    /** validador de forms, se tiene que llamar a buildValidator() antes de usar
     *  @var V 
     */
    protected $validator;

    /** @var class-string<V> */
    protected string $validatorClass;

    /**
     * Path de las views
     */
    protected string $resourcePath;

    /**
     * @param M $model
     * @param class-string<V> $validatorClass
     * @param string $resourcePath
     */
    public function __construct(Model $model, string $validatorClass, string $resourcePath)
    {
        $this->model = $model;
        $this->validatorClass = $validatorClass;
        $this->resourcePath = $resourcePath;
    }
    /**
     * Construlle el Validator mediante el $validatorClass, se tiene que llamar antes de usar el $validator
     */
    protected function buildValidator()
    {
        $this->validator = new $this->validatorClass;
    }

    public abstract function index();
    public abstract function new();
    public abstract function create();
    public abstract function show($id);
    public abstract function edit($id);
    public abstract function update($id);
    public abstract function delete($id);
}
