<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Entities\Contact;
use App\Validation\ContactValidator;
use Ramsey\Uuid\Uuid;

class ContactController extends BaseController
{
    protected $model;
    protected $formValidator;

    public function __construct()
    {
        $this->model = new ContactModel();
        $this->formValidator = new ContactValidator();
    }

    // vistas
    public function index()
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'contacts');

        $data = [
            'title' => 'Contactos',
            'contacts' => $this->model->findAllByBusiness(session()->get('business_id'))
        ];
        return view('Contact/index', $data);
    }
    
    public function new()
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'contacts/new');

        $data['title'] = 'Nuevo Contacto';
        return view('Contact/new', $data);
    }

    public function show($id = null)
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', "contacts/$id");

        $data = [
            'title' => 'Detalles del Contacto',
            'contact' => $this->model->find(uuid_to_bytes($id))
        ];
        return view('Contact/show', $data);
    }

    // acciones
    public function create()
    {
        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $post['business_id'] = uuid_to_bytes(session()->get('business_id'));
        $post['id'] = Uuid::uuid4();

        $this->model->insert(new Contact($post));
        return redirect()->to('/contacts')->with('success', 'Contacto creado exitosamente.');
    }

    public function update($id = null)
    {
        if (!$this->validate($this->formValidator->update)) {
            return redirect()->back()->withInput(); 
        }

        $post = $this->request->getPost();
        $row = [];
        foreach ($post as $key => $value) {
            if ($value && $key !== '_method') $row[$key] = $value;
        }
        if (empty($row)) return redirect()->to('contacts');

        $this->model->update(uuid_to_bytes($id), new Contact($row));
        return redirect()->to('contacts')->with('success', 'Contacto actualizado exitosamente.');
    }

    public function delete($id = null)
    {
        if ($this->model->delete(uuid_to_bytes($id))) {
            return redirect()->to('contacts')->with('success', 'Contacto eliminado exitosamente.');
        } else {
            return redirect()->to('contacts')->with('error', 'No se pudo eliminar el contacto.');
        }
    }
}