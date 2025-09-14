<?php

namespace App\Controllers\Tenants;

use App\Controllers\RestController;
use App\Entities\Item;
use App\Enums\ItemType;
use App\Models\ItemModel;
use App\Models\MeasureUnitModel;
use App\Validation\ItemValidator;

abstract class ItemController extends RestController
{
    protected static array $segments = [
        ItemType::Product->value => 'products',
        ItemType::Supply->value => 'supplies',
    ];
    protected ItemModel $model;
    protected MeasureUnitModel $measureUnitModel;
    protected ItemValidator $formValidator;
    protected ItemType $type;
    protected string $segment;

    public function __construct(ItemType $type)
    {
        $this->type = $type;
        $this->segment = self::$segments[$type->value];
        $this->model = new ItemModel();
    }

    public function index()
    {
        $items = $this->model->findAllByBusinesIdAndType(session('business_id'), $this->type);

        helper('number');

        return view(
            'Tenants/Item/index',
            [
                'title' => $this->type->label(),
                'items' => $items,
                'segment' => $this->segment,
                'type' => $this->type,
            ]
        );
    }

    public function show($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to('tenants/' . $this->segment);
        }

        if ($item->type !== $this->type) {
            return redirect()->to('tenants/' . self::$segments[$item->type->value] . '/' . $item->id);
        }

        helper('number');

        return view(
            'Tenants/Item/show',
            [
                'title' => $this->type->label() . ' - ' . $item->name,
                'segment' => $this->segment,
                'item' => $item
            ],
        );
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            return redirect()->to('tenants/' . $this->segment);
        }

        if ($item->type !== $this->type) {
            return redirect()->to('tenants/' . self::$segments[$item->type->value] . '/' . $item->id . '/edit');
        }

        $this->measureUnitModel = new MeasureUnitModel();

        $measure_units = [];

        foreach ($this->measureUnitModel->findAll() as $unit) {
            $measure_units[$unit->id] = $unit->value;
        }

        return view(
            'Tenants/Item/edit',
            [
                'title' => $this->type->label() . ' - ' . $item->name,
                'item' => $item,
                'measure_units' => $measure_units,
                'segment' => $this->segment,
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

        return view(
            'Tenants/Item/new',
            [
                'title' => $this->type->label(),
                'measure_units' => $measure_units,
                'segment' => $this->segment,
                'type' => $this->type,
            ]
        );
    }
    public function create()
    {
        $this->formValidator = new ItemValidator();

        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }
        $post = $this->request->getPost();

        $post['business_id'] = session('business_id');

        $item = new Item($post);

        $item->type = $this->type;

        if ($this->type === ItemType::Supply) {
            $item->selling_price = null;
        }

        $item->id = $this->model->insert($item, true);

        return redirect()->to('/tenants/' . $this->segment . '/new')->with('success', 'Elemento creado exitosamente ' . $item->name . ', <a href="/tenants/' . $this->segment . '/' . $item->id . '" class="alert-link">Ver</a>');
    }
    public function update($id)
    {
        $this->formValidator = new ItemValidator();

        if (!$this->validate($this->formValidator->create)) {
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

        return redirect()->to('/tenants/' . $this->segment . '/' . $id . '/edit')->with('success', $this->type->label() . ' actualizado exitosamente, <a href="/tenants/' . $this->segment . '/' . $id . '" class="alert-link">Ver</a>');
    }

    public function delete($id)
    {
        echo 'delete';
        if ($this->model->delete($id)) {
            return redirect()->to('/tenants/' . $this->segment)->with('success',  $this->type->label() . ' eliminado exitosamente');
        } else {
            return redirect()->to('/tenants/' . $this->segment)->with('error', 'No se pudo eliminar el ' . $this->type->label());
        }
    }
}
