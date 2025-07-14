<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Entities\Contact;
use App\Validation\Validators\ContactValidator;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class ContactController extends BaseController
{
    use ResponseTrait;

    protected ContactModel $model;
    protected ContactValidator $form_validator;

    public function __construct()
    {
        $this->model = new ContactModel();
        $this->form_validator= new ContactValidator();

        helper('form');
        helper('session');
    }

    /**
     * Muestra la lista de contactos.
     */
    public function index()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'contacts');

        $data = [
            'title' => 'Contactos',
            'contacts' => $this->model->findAllByBusiness(session()->get('business_id'))
        ];
        return view('Contact/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo contacto.
     */
    public function new()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'caontacts/new');

        $data = [
            'title' => 'Crear Nuevo Contacto',
            'validation' => \Config\Services::validation(), // Para mostrar errores de validación
        ];
        return view('Contact/new', $data);
    }

    /**
     * Muestra los detalles de un contacto específico.
     * @param string $id El ID del contacto.
     */
    public function show($id = null)
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', "contacts/$id");

        $contact = $this->model->find(uuid_to_bytes($id));

        if (!$contact) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No se pudo encontrar el contacto con ID: ' . $id);
        }

        $data = [
            'title' => 'Detalles del Contacto',
            'contact' => $contact,
            'validation' => \Config\Services::validation(),
        ];
        return view('Contact/show', $data);
    }

    /**
     * Guarda un nuevo contacto en la base de datos.
     */
    public function create()
    {
        // Validar la entrada del formulario
        
        $post = $this->request->getPost();
        
        $post['business_id'] = uuid_to_bytes(session()->get('business_id'));
        $post['id'] = Uuid::uuid4();
        
        if (!$this->validate($this->form_validator->newRules())) {
            return redirect()->back()->withInput();
        }

        if ($this->model->insert(new Contact($post))) {
            return redirect()->to('/contacts')->with('success', 'Contacto creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el contacto.');
        }
    }

    /**
     * Actualiza un contacto existente.
     * @param string $id El ID del contacto a actualizar.
     */
    public function update($id = null)
    {
        $post = $this->request->getPost(
            ['name', 'email', 'phone', 'address', 'type']
        );
        $row = [];
        foreach ($post as $key => $value) {
            if ($value) $row[$key] = $value;
        }
        if (empty($row)) return redirect()->to('items');

        if (!$this->validate($this->form_validator->showRules())) {
            return redirect()->back()->withInput(); 
        }

        $this->model->update(uuid_to_bytes($id), new Contact($row));
        return redirect()->to('contacts');
    }

    /**
     * Elimina un contacto.
     * @param string $id El ID del contacto a eliminar.
     */
    public function delete($id = null)
    {
        if ($this->model->delete(uuid_to_bytes($id))) {
            return redirect()->to('/contacts')->with('success', 'Contacto eliminado exitosamente.');
        } else {
            return redirect()->to('/contacts')->with('error', 'No se pudo eliminar el contacto.');
        }
    }
}