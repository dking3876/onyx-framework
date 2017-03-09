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
    
    public $zonelist = array(
        'Kwajalein' => -12.00, 
        'Pacific/Midway' => -11.00, 
        'Pacific/Honolulu' => -10.00, 
        'America/Anchorage' => -9.00, 
        'America/Los_Angeles' => -8.00, 
        'America/Denver' => -7.00, 
        'America/Tegucigalpa' => -6.00, 
        'America/New_York' => -5.00, 
        'America/Caracas' => -4.30, 
        'America/Halifax' => -4.00, 
        'America/St_Johns' => -3.30, 
        'America/Argentina/Buenos_Aires' => -3.00, 
        'America/Sao_Paulo' => -3.00, 
        'Atlantic/South_Georgia' => -2.00, 
        'Atlantic/Azores' => -1.00, 
        'Europe/Dublin' => 0, 
        'Europe/Belgrade' => 1.00, 
        'Europe/Minsk' => 2.00, 
        'Asia/Kuwait' => 3.00, 
        'Asia/Tehran' => 3.30, 
        'Asia/Muscat' => 4.00, 
        'Asia/Yekaterinburg' => 5.00, 
        'Asia/Kolkata' => 5.30, 
        'Asia/Katmandu' => 5.45, 
        'Asia/Dhaka' => 6.00, 
        'Asia/Rangoon' => 6.30, 
        'Asia/Krasnoyarsk' => 7.00, 
        'Asia/Brunei' => 8.00, 
        'Asia/Seoul' => 9.00, 
        'Australia/Darwin' => 9.30, 
        'Australia/Canberra' => 10.00, 
        'Asia/Magadan' => 11.00, 
        'Pacific/Fiji' => 12.00, 
        'Pacific/Tongatapu' => 13.00
        );
    
    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
        $this->setTimeZone();
        $this->folders = array(
            ONYX_PATH.'controller/', 
            ONYX_PATH.'includes/', 
            ONYX_PATH.'model/', 
            ONYX_PATH.'service/', 
            ONYX_PATH.'setting/', 
            ONYX_PATH.'classes/',
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
                }elseif(file_exists($dir.$class.'Class.php')){
                    include_once $dir.$class.'Class.php';
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
        //$filename = ONYX_PATH.'settings/onyx/'.$file.'.onyx';
        if(is_dir(BASE_PATH."extensions/".$file)){

        }else if(file_exists(ONYX_PATH.'settings/onyx/'.$file.'.onyx')){
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
    function setTimeZone(){
        $zone = $this->ReadOnyxFile('setup', 'timezone');
        if(!$zone){
            $zone = $this->ReadOnyxFile('setup', 'defaultzone');
        }
        date_default_timezone_set($zone);   
    }
    
    function WriteOnyxFile($file, $settings = null, $prop, $value){
        
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