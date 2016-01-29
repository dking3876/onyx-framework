<?php 
class OnyxAdminController extends OnyxController{
    public function main(){
        if(!$this->model->Onyx->OnyxAuthenticate->Authorized()){
            header("LOCATION: " .BASE_URL."onyx/login");
        }
        if(get_parent_class($this) == 'OnyxAdminController'){
            $this->sub();
        }else{
            $this->renderPage('OnyxDashboard');   
        }
    }
    public function logout(){
        $this->model->Onyx->OnyxAuthenticate->logout();
        header("LOCATION:".BASE_URL."onyx/login");
    }
}