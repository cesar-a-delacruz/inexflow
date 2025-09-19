<?php

namespace App\Controllers\Tenants;

use App\Controllers\BaseController;
use App\Controllers\CRUDController;
use App\Controllers\RestController;
use App\Entities\Item;
use App\Enums\ItemType;
use App\Models\ItemModel;
use App\Models\MeasureUnitModel;
use App\Validation\ItemValidator;

/**
 * @extends CRUDController<Item, ItemModel, ItemValidator>
 */
abstract class ItemController extends CRUDController implements RestController
{
    protected MeasureUnitModel $measureUnitModel;
    protected ItemType $type;
    protected function typeToSegment(?ItemType $itemType = null): string
    {
        return match ($itemType ?? $this->type) {
            ItemType::Product => 'tenants/products',
            ItemType::Supply => 'tenants/supplies',
        };
    }

    public function __construct(ItemType $type)
    {
        $this->type = $type;
        parent::__construct((new ItemModel()), $this->typeToSegment(), ItemValidator::class, 'Template/CRUD');
    }

    public function index()
    {
        $items = $this->model->findAllByBusinessIdAndType(session('business_id'), $this->type);

        helper('number');

        return parent::view(
            'index',
            [
                'title' => $this->type->label(),
                'items' => $items,
                'type' => $this->type,
            ]
        );
    }

    public function show($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to(parent::buildSegments());
        }

        if ($item->type !== $this->type) {
            return redirect()->to($this->typeToSegment($item->type) . '/' . $item->id);
        }

        helper('number');

        return parent::view(
            'show',
            [
                'title' => $this->type->label() . ' - ' . $item->name,
                'item' => $item
            ],
        );
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to(parent::buildSegments());
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
                'title' => $this->type->label() . ' - ' . $item->name,
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
                'title' => $this->type->label(),
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

        $item = new Item($post);

        $item->type = $this->type;

        if ($this->type === ItemType::Supply) {
            $item->selling_price = null;
        }

        $item->id = $this->model->insert($item);

        return redirect()->to(parent::buildSegments() . '/new')->with('success', 'Elemento creado exitosamente ' . $item->name . ', <a href="/' . parent::buildSegments() . '/' . $item->id . '" class="alert-link">Ver</a>');
    }
    public function update($id)
    {
        $this->buildValidator();

        if (!$this->validate($this->validator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        $post['type'] = $this->type->value;

        $item = new Item($post);

        $item->type = $this->type;

        if ($this->type === ItemType::Supply) {
            $item->selling_price = null;
        }

        $this->model->update($id, $item);

        return redirect()->to(parent::buildSegments() . '/' . $id . '/edit')->with('success', $this->type->label() . ' actualizado exitosamente, <a href="/' . parent::buildSegments() . '/' . $id . '" class="alert-link">Ver</a>');
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to(parent::buildSegments())->with('success',  $this->type->label() . ' eliminado exitosamente');
        } else {
            return redirect()->to(parent::buildSegments())->with('error', 'No se pudo eliminar el ' . $this->type->label());
        }
    }
}
