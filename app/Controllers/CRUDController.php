<?php

namespace App\Controllers;

use App\Validation\CRUDValidator;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;

/**
 * @template T of Entity
 * @template M of Model<T>
 * @template V of CRUDValidator<T>
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

    /** @var string[] */
    protected array $segments = [];

    /**
     * Path de las views
     */
    protected string $resourcePath;

    /**
     * @param M $model
     * @param string $segment
     * @param class-string<V> $validatorClass
     * @param string $resourcePath
     */
    public function __construct(Model $model, string $segment, string $validatorClass, string $resourcePath)
    {
        $this->validatorClass = $validatorClass;
        $this->model = $model;
        $this->segments[] = $segment;
        $this->resourcePath = $resourcePath;
    }
    /**
     * Construlle el Validator mediante el $validatorClass, se tiene que llamar antes de usar el $validator
     */
    protected function buildValidator()
    {
        $this->validator = new $this->validatorClass;
    }

    /**
     * Construlle el pathname del controllador
     */
    protected function buildSegments(?string $name = null): string
    {
        $path = implode('/', $this->segments);
        return $name ? $path . '/' . $name : $path;
    }

    /**
     * metodo auxiliar para renderizar views, agrega el segment y el resourcePath
     */
    protected function view(?string $resource = null, array $data = [], array $options = []): string
    {
        $data['segment'] = end($this->segments);
        return view(
            $this->resourcePath . '/' . $resource,
            $data,
            $options
        );
    }
}
