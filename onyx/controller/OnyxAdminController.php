<?php 
class OnyxAdminController extends OnyxController{
    public function main(){
        var_dump($this->model->Onyx->OnyxAuthenticate->Authorized());
        if(get_parent_class($this) == 'OnyxAdminController'){
            $this->sub();
        }
        echo "the admin";
    }
}