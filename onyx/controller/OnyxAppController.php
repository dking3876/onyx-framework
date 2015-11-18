<?php
require_once ONYX_PATH . 'controller/OnyxController.php';

class OnyxAppController extends OnyxController {
    
    static $instance = null;
    
    final static function GetInstance(){
        if(OnyxAppController::$instance == null){
            OnyxAppController::$instance = new OnyxAppController();
            OnyxAppController::$instance->loadController();
        }
        return OnyxAppController::$instance;
    }
    final protected function loadController(){
        include_once $this->base . 'controller/'. $this->defaultController . 'Controller.php';
        $namespace = $this->defaultController;
        if(class_exists($namespace)){
            $tmpController = $this->controller($namespace, 'Onyx');
        }else{
            die('You are trying to load the Controller Class '.$namespace .' without loading the proper Controller scripts');
        }
        return $tmpController;
    }
    final public function main(){
       
    }
}