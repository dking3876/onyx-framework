<?php 
class OnyxLoginController extends OnyxController{
    public function main(){
        if($this->model->Onyx->OnyxAuthenticate->Authorized()){
            header("LOCATION: admin");   
        }
        //$this->model->Onyx->OnyxAuthenticate->login();
        $this->renderPage('OnyxLogin');
    }
}