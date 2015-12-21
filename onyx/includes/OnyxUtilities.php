<?php 
final class OnyxUtilities {
    
    static $instance;
    
    private $folders = array();
    
    public function __construct(){
        session_start();
        
        $this->folders = array(
            ONYX_PATH.'controller/', 
            ONYX_PATH.'includes/', 
            ONYX_PATH.'model/', 
            ONYX_PATH.'service/', 
            ONYX_PATH.'setting/', 
            ONYX_PATH.'setting/database/', 
            ONYX_PATH.'setting/database/tables/',
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
        $folder = strpos($class, 'Onyx') === false? 'data/': 'onyx/';
        
        $type = strpos($class, 'Controller') === false? 'model/' : 'controller/';
        $type = strpos($class, 'Service') === false? $type : 'service/';
        
        $file = BASE_PATH.$folder.$type.$class.'.php';
        $isInterface = strpos($class, 'I') === 0? true: false;
        echo $file.'<br/>';
        if( file_exists($file) ){
            include_once $file;
            
        }else if($isInterface){
            
            foreach($this->folders as $dir){
                echo $dir.$class.'.php<br/>';
                if(file_exists($dir.$class.'.php')){
                    echo 'found file<br/>';
                }
            }
            echo '</pre>';
            
        }else{
            
            $locations = glob(BASE_PATH.'extensions/*/'.$type.$class.'.php');
            if(count($locations) != 0){
                foreach($locations as $file){
                    include_once $file;   
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
        if(file_exists(ONYX_PATH.'setting/onyx/'.$file.'.onyx')){
            $contents = json_decode();
        }else if($extension = glob(BASE_PATH.'extensions/*/'.$file.'.onyx')){
            $content = json_decode();
        }
        if(!$content){
            return false;
            //set up to return onyx error object. "no onyx file exists"
        }
        if($settings == null){
            return $content;
        }
        return return_Onyx_file_array($content, $settings);   
    }
}
$OnyxUtilities = new OnyxUtilities();
//spl_autoload_register('OnyxUtilities::OnyxAutoLoader');