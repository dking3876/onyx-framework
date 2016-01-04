<?php 
final class OnyxUtilities {
    
    static $instance;
    
    private $folders = array();
    
    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
        
        $this->folders = array(
            ONYX_PATH.'controller/', 
            ONYX_PATH.'includes/', 
            ONYX_PATH.'model/', 
            ONYX_PATH.'service/', 
            ONYX_PATH.'setting/', 
            ONYX_PATH.'settings/database/', 
            ONYX_PATH.'settings/database/tables/',
            BASE_PATH.'settings/database/', 
            BASE_PATH.'settings/database/tables/', 
            BASE_PATH.'settings/', 
        );
        spl_autoload_register(array($this, 'OnyxAutoLoader'));
    }
    /*
    static function GetInstance(){
        if(OnyxUtilities::$instance == null){
            OnyxUtilities::$instance = new OnyxUtilities();
        }
        return OnyxUtilities::$instance;
    }
    */
    public function OnyxAutoLoader($class){
        //look into using reflection method to determine if the constructor is public and if not than try the GetInstance method.  will help with the global use of singletons in other classes and extensions
        $folder = strpos($class, 'Onyx') === false? 'data/': 'onyx/';
        
        $type = strpos($class, 'Controller') === false? 'model/' : 'controller/';
        $type = strpos($class, 'Service') === false? $type : 'service/';
        
        $file = BASE_PATH.$folder.$type.$class.'.php';
        $isInterface = strpos($class, 'I') === 0? true: false;
        //echo $file.'<br/>';
        if( file_exists($file) ){
            include_once $file;
            
        }else if($isInterface){
            
            foreach($this->folders as $dir){
                
                if(file_exists($dir.$class.'.php')){
                    include_once $dir.$class.'.php';
                }
            }
            
        }else if(strpos($class, '_table') !== false){
            $found = false;
            $folders = array(
                $this->folders[5],
                $this->folders[6],
                $this->folders[7],
                $this->folders[8],
                $this->folders[9]
                );
            foreach($folders as $dir){
                
                if(file_exists($dir.$class.".php")){
                    $found = true;
                    include_once $dir.$class.".php";   
                }
            }
        }else{
            
            $locations = glob(BASE_PATH.'extensions/*/'.$type.$class.'.php');
            if(count($locations) != 0){
                foreach($locations as $file){
                    include_once $file;   
                }
            }
            
        }
        if(!class_exists($class)){
            foreach($this->folders as $dir){
                if(file_exists($dir.$class.".php")){
                    include_once $dir.$class.".php";   
                }
            }
        }
        /* This doesn't work for interfaces  need to use interface_exists() however need to figure out a good switch statement for use here.*/
        if( !class_exists($class) && !$isInterface ){
            //Throw and error
            die("Attempt to load $class @ {$file} was unsuccessful.  Alternate was not found in the extensions folder.  Your application will now quit");
        }
    }
    
    function ReadOnyxFile($file, $settings = null){
        $content = false;
        $filename = ONYX_PATH.'settings/onyx/'.$file.'.onyx';
        
        if(file_exists(ONYX_PATH.'settings/onyx/'.$file.'.onyx')){
            $f = fopen(ONYX_PATH.'settings/onyx/'.$file.'.onyx', 'r');
            $onyx = fread($f, filesize(ONYX_PATH.'settings/onyx/'.$file.'.onyx'));
            
            $content = json_decode($onyx);
        }else if($extension = glob(BASE_PATH.'extensions/*/'.$file.'.onyx')){
            $content = json_decode();
        }
        if(empty($content)){
            return false;
            //set up to return onyx error object. "no onyx file exists"
        }
        if($settings == null){
            return $content;
        }
        return return_Onyx_file_array($content, $settings);   
    }
    
    public static function objArraySearch($array,$index,$find){
            foreach($array as $key => $value) {
                if($value->{$index} == $find){
                    return $key;
                }
            }
            return null;
    }
}
$OnyxUtilities = new OnyxUtilities();
//spl_autoload_register('OnyxUtilities::OnyxAutoLoader');