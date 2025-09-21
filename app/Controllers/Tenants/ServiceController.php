<?php

namespace App\Controllers\Tenants;

use App\Controllers\CRUDController;
use App\Controllers\RestController;
use App\Entities\Service;
use App\Enums\TransactionType;
use App\Models\ServiceModel;
use App\Models\MeasureUnitModel;
use App\Validation\ServiceValidator;

/**
 * @extends CRUDController<Service, ServiceModel, ServiceValidator>
 */
abstract class ServiceController extends CRUDController implements RestController
{
    protected MeasureUnitModel $measureUnitModel;
    protected TransactionType $type;
    protected function typeToSegment(?TransactionType $type = null): string
    {
        return match ($type ?? $this->type) {
            TransactionType::Income => '/tenants/income-services',
            TransactionType::Expense => '/tenants/expense-services',
        };
    }

    public function __construct(TransactionType $type)
    {
        $this->type = $type;
        parent::__construct((new ServiceModel()), $this->typeToSegment(), ServiceValidator::class, 'tenants/service/', $type->label());
    }

    public function index()
    {
        $items = $this->model->findAllByBusinessIdAndType(session('business_id'), $this->type);

        helper('number');

        return parent::view(
            'index',
            [
                'title' => $this->segmentName,
                'items' => $items,
                'type' => $this->type,
            ]
        );
    }

    public function show($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to($this->segment);
        }

        if ($item->type !== $this->type) {
            return redirect()->to($this->typeToSegment($item->type) . '/' . $item->id);
        }


        return parent::view(
            'show',
            [
                'title' => $this->segmentName . ' - ' . $item->name,
                'item' => $item
            ],
        );
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to($this->segment);
        }

        if ($item->type !== $this->type) {
            return redirect()->to($this->typeToSegment($item->type) . '/' . $item->id . '/edit');
        }

        $this->measureUnitModel = new MeasureUnitModel();

        $measure_units = [];

        foreach ($this->measureUnitModel->findAll() as $unit) {
            $measure_units[$unit->id] = $unit->value;
        }

        return parent::view(
            'edit',
            [
                'title' => $this->segmentName . ' - ' . $item->name,
                'item' => $item,
                'measure_units' => $measure_units,
                'type' => $this->type,
            ]
        );
    }

    public function new()
    {
        $this->measureUnitModel = new MeasureUnitModel();

        $measure_units = [];

        foreach ($this->measureUnitModel->findAll() as $unit) {
            $measure_units[$unit->id] = $unit->value;
        }

        return parent::view(
            'new',
            [
                'title' => $this->segmentName,
                'measure_units' => $measure_units,
                'type' => $this->type,
            ]
        );
    }
    public function create()
    {
        $this->buildValidator();

        if (!$this->validate($this->validator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        $post['business_id'] = session('business_id');

        $item = new Service($post);

        $item->type = $this->type;

        // if ($this->type === TransactionType::Supply) {
        //     $item->selling_price = null;
        // }

        $item->id = $this->model->insert($item);

        return redirect()->to($this->segment . '/new')->with('success', 'Elemento creado exitosamente ' . $item->name . ', <a href="' . $this->segment . '/' . $item->id . '" class="alert-link">Ver</a>');
    }
    public function update($id)
    {
        $this->buildValidator();

        if (!$this->validate($this->validator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        $post['type'] = $this->type->value;

        $item = new Service($post);

        $item->type = $this->type;

        // if ($this->type === TransactionType::Supply) {
        //     $item->selling_price = null;
        // }

        $this->model->update($id, $item);

        return redirect()->to($this->segment . '/' . $id . '/edit')->with('success', $this->segmentName . ' actualizado exitosamente, <a href="' . $this->segment . '/' . $id . '" class="alert-link">Ver</a>');
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to($this->segment)->with('success',  $this->segmentName . ' eliminado exitosamente');
        } else {
            return redirect()->to($this->segment)->with('error', 'No se pudo eliminar el ' . $this->segmentName);
        }
    }
}
