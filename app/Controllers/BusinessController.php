<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Business;
use App\Models\BusinessModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Ramsey\Uuid\Uuid;

class BusinessController extends BaseController
{   
    protected BusinessModel $model;
    protected UserModel $user_model;
    public function __construct() {
        $this->model = new BusinessModel();
        $this->user_model = new UserModel();
    }

    public function new($user_id = null)
    {
        $data['title'] = 'Registrar Negocio';
        $data['user'] = $this->user_model->find(uuid_to_bytes($user_id));
        return view('/Business/new', $data);
    }
    public function show($user_id = null)
    {
        $data['title'] = 'Datos del Negocio';
        $data['user_id'] = $user_id;
        $data['business'] = $this->model->find(uuid_to_bytes(
            $this->user_model->find(uuid_to_bytes($user_id))->business_id
        ));
        return view('/Business/show', $data);
    }
    
    public function create()
    {
        $post = (object) $this->request->getPost(
            ['business_name', 'owner_name', 'owner_email', 'owner_phone', 'user_id']
        );
        $business_id = Uuid::uuid3(Uuid::NAMESPACE_URL, strval(($this->model->getBusinessStats()['total'] + 1)));
        $this->model->createBusiness(new Business([
            'id' => $business_id,
            'business_name' => $post->business_name,
            'owner_name' => $post->owner_name,
            'owner_email' => $post->owner_email,
            'owner_phone' => $post->owner_phone,
            'registered_by'=> uuid_to_bytes($post->user_id),
        ]));
        $this->user_model->update(uuid_to_bytes($post->user_id), ['business_id' => uuid_to_bytes($business_id)]);
        return redirect()->to("user/$post->user_id");
    }
    public function update($user_id = null)
    {
        $business = new Business($this->request->getPost(
            ['business_name', 'owner_name', 'owner_email', 'owner_phone', 'business_id']
        ));
        $this->model->updateBusiness($business->business_id, $business);
        return redirect()->to("/user/$user_id/business");
    }
}
