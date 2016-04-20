<?php
abstract class OnyxController implements IOnyxController {
    
    public $Onyx;
    
    public $model = null;
    
    public $action;
    
    private $html_header = null;
    
    private $html_footer = null;
    
    public $pageTitle = "";
    
    public $pageMeta = array();
    
    
    final protected function __construct($service = null){
        $this->Onyx = &OnyxService::GetInstance();
        $this->model = $this->defaultModel();
        $this->loadAction();
        if($service != "ajax"){
            $this->OnyxAJAX();
        }
        $this->main($service = null);
    }
    /**
     * Setting up for future use to add theming into the framework
     
    public function set_header($header){
        if( count( $head = explode('.', $header) ) == 3 && ( $head[1] == 'html' && $head[2] == 'php' ) ){
            $this->html_header = $header;   
        }else if($header == null){
            $this->html_header = null;
        }else{
            //Trigger Onyx Error object with message "your header must be in the proper format"  {name}.html.php
            return false;
        }
        return true;
    }
    public function set_footer($footer){
        if(count($foot = explode('.', $footer)) == 3 && ( $foot[1] == 'html' && $foot[2] == 'php')){
            $this->html_footer = $footer;   
        }else if($footer == null){
            $this->html_footer = null;
        }else{
            //Trigger Onyx Error object with message "your footer must be in the proper format"  {name}.html.php
            return false;
        }
        return true;
    }
    */
    public function loadAction(){
        if(array_key_exists('action', $this->Onyx->query)){
            $this->action = $this->Onyx->query['action'];   
        }else{
            //echo '<pre>';var_dump($this->Onyx->query);exit();   
        }
    }
    public function set_dependancy($dependancy){
        
    }
    
    final public function view($view,$path = null){
        $base = $path != null ? $path : $this->Onyx->base;
        if(file_exists($base . "view/{$view}.html.php")){
            foreach($this->Onyx->viewData as $item){
                foreach($item as $key => $value){
                    $$key = $value;  
                }
            }
            echo "\r\n";
            
            include_once $base . "view/{$view}.html.php";            
        }else{ 
            echo "couldn't find $base $view View";
        }
        //Throw error if file doesn't exists
    }
    final public function LoadModel($model, $path = null){
        return $this->model($model, $path);   
    }
    final public function model($model = null, $path = null){
        $base = $path ? $path : $this->Onyx->base;
        if($model === null){
            $model = $this->Onyx->controller;
        }
        $model = str_replace("Controller", "Model", $model);
        if(file_exists($base . "model/{$model}.php")){
            //include_once $base . "model/{$model}.php";
            $tmpModel = new $model();
            return $tmpModel;
        }else{
            echo "couldnt' fine $model Model";
        }
        //throw error or just catch and log???
        //return false;
    }
    final public function defaultModel(){
        if($this->model != null){
            return $this->model;   
        }
        $base = $this->Onyx->base;
        $model = $this->Onyx->controller;
        $model = str_replace("Controller", "Model", $model);
        if(file_exists($base . "model/{$model}.php")){
            //include_once $base . "model/{$model}.php";
            $tmpModel = new $model();
            return $tmpModel;
        }
        return null;
    }
    final public function LoadController($controller, $path = null){
        return $this->controller($controller, $path);
    }
    final public function controller($controller, $path = null){
        $tmpController = null;
        $base = $path != null? $path : $this->Onyx->base;
        if(strpos(strtolower($controller), "onyx") !== false && $base != ONYX_PATH){
            $base = ONYX_PATH;   
        } 
        if(file_exists($base . "controller/{$controller}.php")){
            //include_once $base . "controller/{$controller}.php";
            if(class_exists($controller)){
                $this->Onyx->controllers_loaded++;
                $tmpController = new $controller();
            }else{
                die('You are trying to load the Controller Class '.$controller .' without loading the proper Controller scripts');
            }
        }else{ 
            header("HTTP/1.0 404 Not Found");
            if(debug_backtrace()[1]['class'] == "OnyxAppController"){
                echo "this is a page 404 for the $controller ";
            }else{
                echo "couldn't find $controller Controller";
            }
        }
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
        $PageHeaderScripts = function(){
            echo $this->model->renderHeaderScripts();
        };
        $PageStyles = function(){
            echo $this->model->renderStyles();
        };
        $PageTitle = $this->pageTitle  ;
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
        $PageFooterScripts = function(){
            echo $this->model->renderFooterScripts();
        };
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
    
    final public function OnyxAJAX(){
        $check = array();
        foreach($this->Onyx->args as $arg){
            $check[] = strtolower($arg);
        }
        $query = array();
        foreach($this->Onyx->query as $key => $value){
            $query[strtolower($key)] = $value;
        }
        if(array_key_exists('onyxajax', $query)){
            $check[] = 'onyxajax';
            $check[] = $query['onyxajax'];
             
        }
        $functionKey = function($check){
            $keyVal = 0;
            foreach($check as $key => $value){
                if($value == "onyxajax"){
                   $keyVal = ++$key;
                }
            };
            if(isset($check[$keyVal])){
                if(strpos($check[$keyVal], '/') !== false){
                    return explode("/", $check[$keyVal]);
                }else{
                    return $check[$keyVal];
                }
            }
            return false;
        };
        $method = $functionKey($check);
        if(array_search('onyxajax', $check) === false || ( get_class($this) == 'OnyxAppController' && !is_array($method) ) ){
            return;
        }
        if( is_array($method) ){
            $tmpMethod = $method[0].'Controller';
            $tmpController = new $tmpMethod("ajax");
            $tmpController->$method[1]();
            die();
        }else if($method){
            $this->$method();
            die();
        }else{
            die('No method');
        }
    }
    
    final public function setting($key, $value = null){
        return $this->model->setting($key, $value);
    }
    
}