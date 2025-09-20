<?php

namespace App\Controllers\Tenants;

use App\Controllers\CRUDController;
use App\Controllers\RestController;
use App\Entities\Contact;
use App\Enums\ContactType;
use App\Models\ContactModel;
use App\Validation\ContactValidator;
/*
 * @extends CRUDController<Contact, ContactModel, ContactValidator>
*/

abstract class ContactController extends CRUDController implements RestController
{
    protected ContactType $type;
    protected function typeToSegment(?ContactType $type = null): string
    {
        return match ($type ?? $this->type) {
            ContactType::Provider => '/tenants/providers',
            ContactType::Customer => '/tenants/customers',
        };
    }

    public function __construct(ContactType $type)
    {
        $this->type = $type;
        parent::__construct((new ContactModel()), $this->typeToSegment(), ContactValidator::class, 'tenants/contact/', $type->label());
    }

    public function index()
    {
        $items = $this->model->findAllByBusinessIdAndType(session('business_id'), $this->type);

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

        return parent::view(
            'edit',
            [
                'title' => $this->segmentName . ' - ' . $item->name,
                'item' => $item,
                'type' => $this->type,
            ]
        );
    }

    public function new()
    {
        return parent::view(
            'new',
            [
                'title' => $this->segmentName,
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

        $item = new Contact($post);

        $item->type = $this->type;

        $item->id = $this->model->insert($item, true);

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

        $item = new Contact($post);

        $item->type = $this->type;

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
