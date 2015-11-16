<?php
class OnyxController {
    public $page;
    
    public $action;
    
    public $model;
    
    public $view;
    
    final private function getPath(){
        
    }
    
    public function getAction(){
        
    }
    
    public function loadController(){
        
    }
    final public function view($view,$path = DATA_PATH){
        include $path . "view/{$view}/{$view}.php";
    }
    
    final public function model($model, $path = DATA_PATH){
        include $path . "model/{$model}.php";
        $tmpModel = new $model();
        return $tmpModel;
    }
}