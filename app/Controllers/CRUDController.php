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

    protected string $segment;

    /**
     * Path de las views
     */
    protected string $resourcePath;
    protected string $segmentName;

    /**
     * @param M $model
     * @param string $segment
     * @param class-string<V> $validatorClass
     * @param string $resourcePath
     */
    public function __construct(Model $model, string $segment, string $validatorClass, string $resourcePath, string $segmentName)
    {
        $this->validatorClass = $validatorClass;
        $this->model = $model;
        $this->segment = $segment;
        $this->resourcePath = $resourcePath;
        $this->segmentName = $segmentName;
    }
    /**
     * Construlle el Validator mediante el $validatorClass, se tiene que llamar antes de usar el $validator
     */
    protected function buildValidator()
    {
        $this->validator = new $this->validatorClass;
    }


    /**
     * metodo auxiliar para renderizar views, agrega el segment y el resourcePath
     */
    protected function view(?string $resource = null, array $data = [], array $options = []): string
    {
        $data['segment'] = $this->segment;
        $data['segmentName'] = $this->segmentName;
        return view(
            $this->resourcePath . '/' . $resource,
            $data,
            $options
        );
    }
}
