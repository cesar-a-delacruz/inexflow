<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Business;
use App\Models\BusinessModel;
use App\Validation\BusinessValidator;
use Ramsey\Uuid\Uuid;

class BusinessController extends BaseController
{   
    protected $model;
    protected $formValidator;
    
    public function __construct() 
    {
        $this->model = new BusinessModel();
        $this->formValidator = new BusinessValidator();
    }

    // vistas
    public function new()
    {
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'business/new');

        $data['title'] = 'Crear Negocio';
        return view('Business/new', $data);
    }

    public function show()
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'business');

        $data = [
            'title' => 'Información del Negocio',
            'business' => $this->model->find(uuid_to_bytes(session()->get('business_id'))),
        ];
        return view('Business/show', $data);
    }
    
    // acciones
    public function create()
    {
        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $post['id'] = Uuid::uuid4();
        $post['owner_id'] = uuid_to_bytes(session()->get('id'));

        session()->set('business_id', uuid_to_string($post['id']));

        $this->model->insert(new Business($post));
        return redirect()->to('business');
    }

    public function update()
    {
        if (!$this->validate($this->formValidator->update)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $row = [];
        foreach ($post as $key => $value) {
            if ($value && $key !== '_method') $row[$key] = $value;
        }
        if (empty($row)) return redirect()->to('business');

        $this->model->update(uuid_to_bytes(session()->get('business_id')), new Business($row));
        return redirect()->to('business');
    }
}
