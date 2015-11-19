<?php
require_once ONYX_PATH . 'controller/OnyxController.php';

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
    /*
    final protected function loadController(){
        if(file_exists($this->Onyx->base . 'controller/'. $this->Onyx->controller . 'Controller.php'){
            include_once $this->Onyx->base . 'controller/'. $this->Onyx->controller . 'Controller.php';
            $namespace = $this->Onyx->controller;
            if(class_exists($namespace)){
                $tmpController = $this->controller($namespace);
            }else{
                die('You are trying to load the Controller Class '.$namespace .' without loading the proper Controller scripts');
            }
        }
        //Throw an error file doesn't exists
           
        return $tmpController;
    }
    */

}