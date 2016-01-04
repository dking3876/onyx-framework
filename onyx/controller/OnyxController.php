<?php
abstract class OnyxController implements IOnyxController {
    
    public $Onyx;
    
    public $model;
    
    public $action;
    
    private $html_header = null;
    
    private $html_footer = null;
    
    final protected function __construct($service = null){
        $this->Onyx = &OnyxService::GetInstance();
        
        $this->OnyxAJAX();
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
        
    }
    public function set_dependancy($dependancy){
        
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
        }else{ 
            echo "couldn't find $view View";
        }
        //Throw error if file doesn't exists
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
    final public function controller($controller, $path = null){
        $tmpController = null;
        $base = $path != null? $path : $this->Onyx->base;
        
        if(file_exists($base . "controller/{$controller}.php")){
            //include_once $base . "controller/{$controller}.php";
            if(class_exists($controller)){
                $tmpController = new $controller();
            }else{
                die('You are trying to load the Controller Class '.$controller .' without loading the proper Controller scripts');
            }
        }else{ 
            echo "couldn't find $controller Controller";
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
    
    final public function OnyxAJAX(){
        $check = array();
        foreach($this->Onyx->args as $arg){
            $check[] = strtolower($arg);
        }
        if(array_search('onyxajax', $check) === false || get_class($this) == 'OnyxAppController'){
           
            return;
        }
        
        //Get position of OnyxAJAX in array and use the next position of the array for the actual function to run
        $i = 1;
        var_dump($this->Onyx->args);
        $method = $this->Onyx->args[$i];
        $this->$method();
        die();
    }
}