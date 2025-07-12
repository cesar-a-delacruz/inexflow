<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Entities\Contact;
use CodeIgniter\API\ResponseTrait;

class ContactController extends BaseController
{
    use ResponseTrait;

    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    /**
     * Muestra la lista de contactos.
     */
    public function index()
    {
        $data = [
            'title' => 'Listado de Contactos',
            'contacts' => $this->contactModel->findAll(), // Obtiene todos los contactos
        ];
        return view('Contact/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo contacto.
     */
    public function new()
    {
        $data = [
            'title' => 'Crear Nuevo Contacto',
            'validation' => \Config\Services::validation(), // Para mostrar errores de validación
        ];
        return view('Contact/new', $data);
    }

    /**
     * Guarda un nuevo contacto en la base de datos.
     */
    public function create()
    {
        // Validar la entrada del formulario
        if (!$this->validate($this->contactModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $newContact = new Contact($this->request->getPost());

        // Aquí deberías establecer el business_id, ya que no se pide en el formulario.
        // Asumiendo que obtienes el business_id de la sesión o de algún otro lugar.
        // Por ejemplo:
        $newContact->business_id = session('business_id'); // O de donde sea que lo obtengas

        if ($this->contactModel->save($newContact)) {
            return redirect()->to('/contacts')->with('success', 'Contacto creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el contacto.');
        }
    }

    /**
     * Muestra los detalles de un contacto específico.
     * @param string $id El ID del contacto.
     */
    public function show($id = null)
    {
        $contact = $this->contactModel->find($id);

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
     * Actualiza un contacto existente.
     * @param string $id El ID del contacto a actualizar.
     */
    public function update($id = null)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No se pudo encontrar el contacto con ID: ' . $id);
        }

        // Validar la entrada del formulario
        if (!$this->validate($this->contactModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $contact->fill($this->request->getPost());

        if ($this->contactModel->save($contact)) {
            return redirect()->to('/contacts/' . $id)->with('success', 'Contacto actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el contacto.');
        }
    }

    /**
     * Elimina un contacto.
     * @param string $id El ID del contacto a eliminar.
     */
    public function delete($id = null)
    {
        if ($this->contactModel->delete($id)) {
            return redirect()->to('/contacts')->with('success', 'Contacto eliminado exitosamente.');
        } else {
            return redirect()->to('/contacts')->with('error', 'No se pudo eliminar el contacto.');
        }
    }
}