<?php 
class OnyxAdminController extends OnyxController{
    final public function main(){
        if(!$authorized = $this->model->Onyx->OnyxAuthenticate->Authorized()){
            header("LOCATION: " .BASE_URL."onyx/login");
        }
        $this->Onyx->viewData(array(
            'authorized'    => $authorized
            ));
        $this->model->headerScripts('bootstrap','onyx');
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