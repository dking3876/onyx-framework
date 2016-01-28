<?php
class OnyxAppController extends OnyxController {
    
    static $instance = null;
    
    final public function main(){
        $this->controller($this->Onyx->controller);
    }
    final static function GetInstance(){
        if(OnyxAppController::$instance == null){
            OnyxAppController::$instance = new OnyxAppController();
        }
        return OnyxAppController::$instance;
    }
}