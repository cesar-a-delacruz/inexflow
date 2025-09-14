<?php

namespace App\Controllers\Tenants;

use App\Controllers\RestController;
use App\Entities\Contact;
use App\Entities\Item;
use App\Enums\ContactType;
use App\Models\ContactModel;
use App\Models\ItemModel;
use App\Validation\ContactValidator;
use App\Validation\ItemValidator;

abstract class ContactController extends RestController
{
    protected static array $segments = [
        ContactType::Customer->value => 'customers',
        ContactType::Provider->value => 'providers',
    ];
    protected ContactModel $model;
    protected ContactValidator $formValidator;
    protected ContactType $type;
    protected string $segment;

    public function __construct(ContactType $type)
    {
        $this->type = $type;
        $this->segment = self::$segments[$type->value];
        $this->model = new ContactModel();
    }

    public function index()
    {
        $contacts = $this->model->findAllByBusinesIdAndType(session('business_id'), $this->type);

        return view(
            'Tenants/Contact/index',
            [
                'title' => $this->type->label(),
                'contacts' => $contacts,
                'segment' => $this->segment,
                'type' => $this->type,
            ]
        );
    }

    public function show($id)
    {
        $contact = $this->model->find($id);

        if (!$contact) {
            return redirect()->to('tenants/' . $this->segment);
        }

        if ($contact->type !== $this->type) {
            return redirect()->to('tenants/' . self::$segments[$contact->type->value] . '/' . $contact->id);
        }

        helper('number');

        return view(
            'Tenants/Contact/show',
            [
                'title' => $this->type->label() . ' - ' . $contact->name,
                'segment' => $this->segment,
                'contact' => $contact
            ],
        );
    }

    public function edit($id)
    {
        $contact = $this->model->find($id);

        if (!$contact) {
            return redirect()->to('tenants/' . $this->segment);
        }

        if ($contact->type !== $this->type) {
            return redirect()->to('tenants/' . self::$segments[$contact->type->value] . '/' . $contact->id . '/edit');
        }

        return view(
            'Tenants/Contact/edit',
            [
                'title' => $this->type->label() . ' - ' . $contact->name,
                'contact' => $contact,
                'segment' => $this->segment,
                'type' => $this->type,
            ]
        );
    }

    public function new()
    {
        return view(
            'Tenants/Contact/new',
            [
                'title' => $this->type->label(),
                'segment' => $this->segment,
                'type' => $this->type,
            ]
        );
    }
    public function create()
    {
        $this->formValidator = new ContactValidator();

        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        $post['business_id'] = session('business_id');

        $contact = new Contact($post);

        $contact->type = $this->type;

        $contact->id = $this->model->insert($contact, true);

        return redirect()->to('/tenants/' . $this->segment . '/new')->with('success', 'Elemento creado exitosamente ' . $contact->name . ', <a href="/tenants/' . $this->segment . '/' . $contact->id . '" class="alert-link">Ver</a>');
    }

    public function update($id)
    {
        $this->formValidator = new ContactValidator();

        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        $post['type'] = $this->type->value;

        $contact = new Contact($post);

        $contact->type = $this->type;

        $this->model->update($id, $contact);

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
