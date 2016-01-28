<?php 
class OnyxLoginController extends OnyxController{
    public function main(){
        if($this->model->Onyx->OnyxAuthenticate->Authorized()){
            header("LOCATION: admin");   
        }
        $this->model->Onyx->OnyxAuthenticate->login();
        echo 'This is for logging into the backend';
        echo '<pre>';
        var_dump($_SESSION);
    }
}