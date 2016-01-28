<?php 
/**
 *
 */
final class OnyxUtilities {
    /**
     *
     */
    static $instance;
    
    /**
     *
     */
    private $folders = array();
    /**
     * Contructor for the OnyxUtilities
     */
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
    /**
     * OnyxAutoLoader
     * 
     * Handles the autoloading of any classes not yet instantiated.
     * 
     * @param string $class Class Name for needed object
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
    /**
     * Loads and reads the contents of onyxfiles.
     * 
     * Onyx files are files with the .onyx extension and are JSON data needed for settings and parrameters of both the onyx core 
     * system and any extensions
     * @param  string $file              Onyx File needed to load
     * @param  string [$settings = null] Settings attempting to retrieve
     * @return boolean/array  Return a boolean if the setting cannot be retrieved or an array containing the setting.
     */
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
    /**
     * Method for returning the needed key of an object 
     * @param  array $array The array to search through
     * @param  string $index the index in the array we are trying to look through
     * @param  string $find  the index we are trying to find
     * @return array the array if it is found  
     */
    public static function objArraySearch($array,$index,$find){
            foreach($array as $key => $value) {
                if($value->{$index} == $find){
                    return $key;
                }
            }
            return null;
    }
    //shell to check for 404 error to handle redirects
    public static function checkurl($url){
        // Simple check
        if (!$url)
        {
            return FALSE;
        }

        // Create cURL resource using the URL string passed in
        $curl_resource = curl_init($url);

        // Set cURL option and execute the "query"
        curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl_resource);

        // Check for the 404 code (page must have a header that correctly display 404 error code according to HTML standards
        if(curl_getinfo($curl_resource, CURLINFO_HTTP_CODE) == 404)
        {
            // Code matches, close resource and return false
            curl_close($curl_resource);
            return FALSE;
        }
        else
        {
            // No matches, close resource and return true
            curl_close($curl_resource);
            return TRUE;
        }

        // Should never happen, but if something goofy got here, return false value
        return FALSE;
    }
}
$OnyxUtilities = new OnyxUtilities();
//spl_autoload_register('OnyxUtilities::OnyxAutoLoader');