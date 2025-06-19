<?php

namespace   App\Controllers;

class RecoveryController extends BaseController{

 public function __construct(){
    helper('url');
 }

 public function index(){
        $data['title'] = 'Recovery';
        return view ('Recovery/recovery',$data);
 }

 public function questions(){
   $data['title'] = 'Preguntas de Seguridad';
   return view ('Recovery/questions',$data);
 }

 //Simulacion de Obtencion de respuestas - No implementado
 public function Verifyquestions(){

    $respuesta1 = $this->request->getPost('respuesta1'); 
    $respuesta2 = $this->request->getPost('respuesta2'); 
    $respuesta3 = $this->request->getPost('respuesta3');

    if($respuesta1 && $respuesta2 && $respuesta3){
        return redirect()->to(base_url('resetpassword'))->with('message','Respuestas Correctas');
    }
    else {
        return redirect()->back()->with('message','Responda todas las preguntas');
    }
 }

 public function UpdatePassword(){
    $data['title'] = 'Update Password';
    return view('Recovery/Updatepassw',$data);
 }

 //Simulacion de
 public function ResetPassword(){

    return redirect()->to(base_url('login'))->with('message','Contraseña actualizada');
 }
}
