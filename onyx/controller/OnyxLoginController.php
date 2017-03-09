<?php 
class OnyxLoginController extends OnyxController{
    public function main(){
        if($authorized = $this->model->Onyx->OnyxAuthenticate->Authorized()){
            header("LOCATION: admin");   
        }
        $this->Onyx->viewData(array(
            'authorized'    => $authorized
            ));
        $this->pageTitle = "Onyx | Login";
        $this->model->headerScripts('jquery', 'onyx');
        $this->model->headerScripts('jquery-ui', 'onyx');
        $this->model->headerScripts('bootstrap','onyx');
        $this->model->styles(array(
            'name'  => 'bootstrap', 
            'file'  => 'bootstrap.min.css',
        ),'onyx');
        //$this->model->Onyx->OnyxAuthenticate->login();
        
        if(isset($this->Onyx->query['forgot'])){
            $_thisPage = $this->Onyx->query['forgot'];
            $this->renderPage('forgot');
            exit();
        }else if(isset($this->Onyx->query['onyx_login'])){
            $attempts = ++$this->Onyx->query['onyx_login'];
            $this->Onyx->viewData(array(
                'attempts'  => $attempts
                ));
            $user = '';
            $pass = '';
            $this->model->Onyx->OnyxAuthenticate->login($user, $pass);
        }
        $this->renderPage('OnyxLogin');;
    }
    
    public function login(){
        
    }
    
    public function logout(){
        
    }
    
    public function forgot_password(){
        
    }
}