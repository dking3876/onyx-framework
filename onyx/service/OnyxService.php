<?php
require_once BASE_PATH . 'onyx/service/OnyxServiceExtention.php';
final class OnyxService extends OnyxServiceExtention {
    
    private $parsedUrl; //Entire Url parsed out into Protocal(scheme), host, path, QueryString(query)
    
    /**
     *
     *  $path[0] == Page visited(controller to load) $path[0].Controller 
     *  $path[1] == Directory if exists in which case $path[0].$path[1].Controller is loaded
     *  (If $path[0] is Controller loaded) : $path[1] + will all be usuable parts accessable by $this->Onyx->args[]
     *  
     */
    private $path = array();
    
    /**
     *  $rawArgs[] contains all path parts accessable by $this->Onyx->rawArgs[] should they be needed by either the controller or the model.  These are raw as entered 
     *  directly into the url string.
     *  
     *  $args[] contains all path parts accessable by $this->Onyx->args[] should they be needed by either the controller or the model.  The are more usable converted
     *  to Uppercase first letter for better loading of file names. NOTE*@ToDo : Will probably turn out to be unnessary 
     */
    public $args, $rawArgs = array();
    
    /**
     *  $path holds the path for loading the Controller, Default is set for DATA_PATH
     */
    public $base = DATA_PATH;
    /**
     *  $controller is the Default controller to Load as determined by the path.
     */
    public $controller;
    
    /**
     *  $query stores all REQUESTABLE VARIABLES $_GET, $_POST, $_FILE
     */
    public $query = array();
    
    /**
     *  $viewData stores any data that may need to be passed between Model and the View.  Store a key value pair array ie array("MyKey" => "MyValue")
     */
    public $viewData;
    
    public $OnyxAuthenticate;
    
    public $OnyxIntercepts;
    
    static $instance = null;
    
    
    final private function __construct(){
        $this->getPath();
    }    
    final static function GetInstance(){
        if(OnyxService::$instance == null){
            OnyxService::$instance = new OnyxService();
        }
        return OnyxService::$instance;
    }
    
    final protected function getPath(){
        
        
        $rawUrl = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($rawUrl);
    
        $this->parsedUrl = $parsedUrl;
        
        
        $path = $this->path = $this->rawArgs = $this->parsedUrlHelper($parsedUrl);
        foreach($this->rawArgs as $value){
            $path[] = ucfirst($value);
        }
        
        
        $this->args = $path;
        if(isset($path[0])){
            if($path[0] == "Onyx"){
                $this->base = ONYX_PATH;

                $this->controller = $path[0].(isset($path[1])? $path[1] : '').'Controller';
            }else{
                $this->controller = $path[0].'Controller';
            }
        }
        $queryString = explode("&", ( isset($this->parsedUrl['query']) ? $this->parsedUrl['query'] : '' ) );
        
        foreach($queryString as $query){
            $args = explode("=", $query);
            $this->query[$args[0]] = isset($args[1]) ?$args[1] : null;
        }
        if(isset($_POST)){
            foreach($_POST as $key => $value){
                $this->query[$key] = $value;
            }
        }
        if(isset($_FILE)){
            foreach($_FILE as $key => $value){
                $this->query[$key] = $value;
            }
        }
        $this->query = array_filter($this->query);

    }
    final private function parsedUrlHelper($parsedUrl){
        //For helping with local file system and installation is subfolders
        $newRaw = rtrim(str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', BASE_PATH), '/');
        $newRaw = str_replace('\\', '/', $newRaw);
        
        $parsedUrl['path'] = str_replace($newRaw, '', $parsedUrl['path']);
        
        return  array_values(array_filter(explode('/',$parsedUrl['path'])));;
    }
    
    final public function OnyxIntercept($action, $function, $args = null){
        $this->OnyxIntercepts[] = array(
            'action'    => $action,
            'function'  => $function,
            'arguments' => $args
        );
    }
    final public function viewData($args){
        $this->viewData[] = $args;   
    }
}