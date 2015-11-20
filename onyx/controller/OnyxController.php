<?php
require_once ONYX_PATH . 'controller/IOnyxController.php';
include_once ONYX_PATH . 'service/OnyxService.php';
abstract class OnyxController implements IOnyxController {
    
    public $Onyx;
    
    public $model;
    
    public $action;
    
    final protected function __construct($service = null){
        $this->Onyx = &OnyxService::GetInstance();
        $this->main($service = null);
    }
    
    public function loadAction(){
        
    }
    
    
    final public function view($view,$path = null){
        $base = $path ? $path : $this->Onyx->base;
        if(file_exists($path . "view/{$view}.html.php")){
            foreach($this->Onyx->viewData as $item){
                foreach($item as $key => $value){
                    $$key = $value;  
                }
            }
            echo "\r\n";
            include_once $path . "view/{$view}.html.php";
        }else{ echo "couldn't find $view View";}
        //Throw error if file doesn't exists
    }
    
    final public function model($model = null, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if($model === null){
            $model = $this->Onyx->controller;
        }
        $model = str_replace("Controller", "Model", $model);
        if(file_exists($base . "model/{$model}.php")){
            include_once $base . "model/{$model}.php";
            $tmpModel = new $model();
            return $tmpModel;
        }else{ echo "couldnt' fine $model Model"; }
        //throw error or just catch and log???
        //return false;
    }
    final public function controller($controller, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if(file_exists($base . "controller/{$controller}.php")){
            include_once $base . "controller/{$controller}.php";
            if(class_exists($controller)){
                $tmpController = new $controller();
            }else{
                die('You are trying to load the Controller Class '.$controller .' without loading the proper Controller scripts');
            }
        }else{ echo "couldn't find $controller Controller";}
        //Throw error if file doesn't exists
        return $tmpController;
    }
    final public function renderHeader($header = null, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if($header === null){
            $header = "header";    
        }
            foreach($this->Onyx->viewData as $item){
                foreach($item as $key => $value){
                    $$key = $value;  
                }
            }
        $PageHeaderScripts = $this->model->renderHeaderScripts();
        $PageStyles = $this->model->renderStyles();
        $PageTitle = '';
        $PageMeta = '';
        if(file_exists($base .  "view/{$header}.html.php")){
            include_once $base .  "view/{$header}.html.php";
        }else{ echo "couldn't find $header Header"; }
    }
    final public function renderFooter($footer = null, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if($footer === null){
            $footer = "footer";    
        }
            foreach($this->Onyx->viewData as $item){
                foreach($item as $key => $value){
                    $$key = $value;  
                }
            }
        $PageFooterScripts = $this->model->renderFooterScripts();
        if(file_exists($base .  "view/{$footer}.html.php")){
            include_once $base .  "view/{$footer}.html.php";
        }else{ echo "coultn' fine $footer Footer";}
    }
    
    final public function renderPage($page = null, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if($page == null){
            $page = $this->Onyx->controller;  
        }
        $page = str_replace("Controller", "", $page);
        $this->renderHeader();
        if(file_exists($base.'view/'.$page.".html.php")){
            $this->view($page, $base);
        }
        else{
            echo '<br/>view does not exist rendering page error';
        }
        $this->renderFooter();
    }
    final public function OnyxIntercept($action, $function, $args = null){
        $this->Onyx->OnyxIntercepts[] = array(
            'action'    => $action,
            'function'  => $function,
            'arguments' => $args
        );
    }
}