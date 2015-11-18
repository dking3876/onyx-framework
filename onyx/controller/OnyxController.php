<?php
require_once ONYX_PATH . 'controller/IOnyxController.php';

abstract class OnyxController implements IOnyxController {
    
    protected $defaultController;
    
    protected $defaultModel;
    
    public $path;
    
    public $action;
    
    public $model;
    
    public $view;
    
    protected $base = BASE_PATH . 'controller/';
    
    public $Onyx;
    
    public $OnyxAuthenticate;
    
    public $OnyxIntercepts;
    
    public $viewData = array();
    
    final protected function __construct($Onyx = null){
        if($Onyx !== null){
            $this->Onyx = $Onyx;
        }
        $this->defaultController = $this->getPath();
        $this->model = $this->model($this->defaultController, $this->base);
        $this->defaultModel = get_class($this->model);
        if(method_exists($this, $this->action)){
            $action = $this->action;
            $this->$action();
        }
        else{
            $this->main();
        }
    }
    
    final public function GetController($namespace = null,OnyxController $instance){
        if($namespace !== null){
            $tmpController = new $namespace($instance);
        }else{
           
        }
    }
    final protected function getPath(){
        $base = BASE_PATH;
        $newRaw = rtrim(str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', $base), '/');
        $newRaw = str_replace('\\', '/', $newRaw);
        $rawUrl = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($rawUrl);
        $parsedUrl['path'] = str_replace($newRaw, '', $parsedUrl['path']);
        $rawPath = array_values(array_filter(explode('/',$parsedUrl['path'])));
        foreach($rawPath as $value){
            $path[] = ucfirst($value);
        }
        $controller = $path[0];
        $this->path = $rawPath;
        if($path[0] == "Onyx"){
            $this->base = ONYX_PATH;
            $controller = $path[0].$path[1];
            unset($path[0]);
        }else{
            $controller = $path[0];
        }
        unset($path[1]);
        if(count($path) != 0){
            $this->action = $path[0];
            if(count($path) != 1){
                unset($path[0]);
                $path = array_values($path);
                $this->query = implode('/',$path);
            }
        }
        return $controller;
            /*
        $PathParts = $this->OnyxModel->getPath();
        $this->path = $PathParts['path'];
        $this->base = $PathParts['base'];
        $this->defaultController = $PathParts['controller'];
        if(isset($PathParts['action'])){
            $this->action = $PathParts['action'];
        }
        if(isset($PathParts['query'])){
            $this->query = $PathParts['query'];
        }
        */
        
    }
    
    public function loadAction(){
        
    }
    
    
    final public function view($view,$path = DATA_PATH){
        foreach($this->viewData as $key => $value){
            $$key = $value;   
        }
        echo "\r\n";
        include_once $path . "view/{$view}.html.php";
    }
    
    final public function model($model = null, $path = DATA_PATH){
        if($path == 'Onyx'){
            $path = ONYX_PATH;
        }
        if($model === null){
            $model = $this->defaultController;
        }
        $model = $model."Model";
        if(file_exists($path . "model/{$model}.php")){
            include_once $path . "model/{$model}.php";
            $tmpModel = new $model();
            return $tmpModel;
        }
        return false;
    }
    final public function controller($controller, $path = DATA_PATH){
        if($path == 'Onyx'){
            $path = ONYX_PATH;
        }
        include_once $path . "controller/{$controller}Controller.php";
        if(class_exists($controller)){
            $tmpController = $this->GetController($controller, OnyxAppController::$instance);
        }else{
            die('You are trying to load the Controller Class '.$namespace .' without loading the proper Controller scripts');
        }
        return $tmpController;
    }
    final public function renderHeader($header = null, $path = DATA_PATH){
        $path = $this->base;
        if($header == null){
            $header = "header";    
        }
        foreach($this->viewData as $key => $value){
            $$key = $value;   
        }
        $PageHeaderScripts = $this->model->renderHeaderScripts();
        $PageStyles = $this->model->renderStyles();
        $PageTitle = '';
        $PageMeta = '';
        include_once $path .  "view/{$header}.html.php";
    }
    final public function renderFooter($footer = null, $path = DATA_PATH){
        $path = $this->base;
        if($footer == null){
            $footer = "footer";    
        }
        foreach($this->viewData as $key => $value){
            $$key = $value;   
        }
        $PageFooterScripts = $this->model->renderFooterScripts();
        include_once $path .  "view/{$footer}.html.php";
    }
    
    final public function renderPage($page = null, $path = DATA_PATH){
        $path = $this->base;
        if($page == null){
            $page = $this->defaultController;  
        }
        $this->renderHeader();
        if(file_exists($path.'view/'.$page.".html.php")){
            $this->view($page, $path);
        }
        else{
            echo '<br/>view does not exist error';
        }
        $this->renderFooter();
    }
    final public function OnyxIntercept($action, $function, $args = null){
        $this->OnyxIntercepts[] = array(
            'action'    => $action,
            'function'  => $function,
            'arguments' => $args
        );
    }
    final public function viewData($args){
        $this->viewData = $args;   
    }
}