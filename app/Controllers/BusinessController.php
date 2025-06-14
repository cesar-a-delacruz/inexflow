<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Business;
use App\Models\{BusinessModel, UserModel};
use Ramsey\Uuid\Uuid;

class BusinessController extends BaseController
{   
    protected BusinessModel $model;
    protected UserModel $user_model;
    public function __construct() {
        $this->model = new BusinessModel();
        $this->user_model = new UserModel();
    }

    public function new()
    {
        session()->set('current_page', 'user/business/new');
        $session_id = session()->get('id');

        $data['title'] = 'Nuevo Negocio';
        $data['user'] = $this->user_model->find(uuid_to_bytes($session_id));
        return view('Business/new', $data);
    }
    public function show()
    {
        session()->set('current_page', 'user/business');
        $session_id = session()->get('id');

        $data['title'] = 'Información del Negocio';
        $data['business'] = $this->model->find(uuid_to_bytes(
            $this->user_model->find(uuid_to_bytes($session_id))->business_id
        ));
        return view('Business/show', $data);
    }
    
    public function create()
    {
        $post = (object) $this->request->getPost(
            ['business_name', 'owner_name', 'owner_email', 'owner_phone']
        );
        $business_id = Uuid::uuid3(Uuid::NAMESPACE_URL, strval(($this->model->getBusinessStats()['total'] + 1)));
        $session_id = session()->get('id');
        $this->model->createBusiness(new Business([
            'id' => $business_id,
            'business_name' => $post->business_name,
            'owner_name' => $post->owner_name,
            'owner_email' => $post->owner_email,
            'owner_phone' => $post->owner_phone,
            'registered_by'=> uuid_to_bytes($session_id),
        ]));

        $this->user_model->update(
            uuid_to_bytes($session_id), ['business_id' => uuid_to_bytes($business_id)]
        );

        return redirect()->to('user');
    }
    public function update()
    {
        $business = new Business($this->request->getPost(
            ['business_name', 'owner_name', 'owner_email', 'owner_phone', 'business_id']
        ));
        
        $this->model->updateBusiness($business->business_id, $business);
        return redirect()->to('user/business');
    }
}
