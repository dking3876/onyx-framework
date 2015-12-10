<?php 
session_start();
class OnyxUtilities {
    
    static $instance;
    
    private function __contruct(){
        
    }
    
    static function GetInstance(){
        if(OnyxUtilities::$instance == null){
            OnyxUtilities::$instance = new OnyxUtilities();
        }
        return OnyxUtilities::$instance;
    }
    
    static function OnyxAutoLoader($class){
        $folder = strpos($class, 'Onyx') === false? 'data/': 'onyx/';
        
        $type = strpos($class, 'Controller') === false? 'model/' : 'controller/';
        $type = strpos($class, 'Service') === false? $type : 'service/';
        
        $file = BASE_PATH.$folder.$type.$class.'.php';
        
        if( file_exists($file) ){
            include_once $file;
        }else{
            $locations = glob(BASE_PATH.'extensions/*/'.$type.$class.'.php');
            if(count($locations) != 0){
                foreach($locations as $file){
                    include_once $file;   
                }
            }
            
        }
        /* This doesn't work for interfaces  need to use interface_exists() however need to figure out a good switch statement for use here.
        if(!class_exists($class) ){
            //Throw and error
            die("Attempt to load $class @ {$file} was unsuccessful.  Alternate was not found in the extensions folder.  Your application will now quit");
        }
        */
    }
    
    function ReadOnyxFile(){
           
    }
}
spl_autoload_register('OnyxUtilities::OnyxAutoLoader');