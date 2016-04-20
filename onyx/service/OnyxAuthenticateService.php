<?php 
final class OnyxAuthenticate implements IonyxAuthenticate {
    
    private $salt;
    private $encryptionKey;
    private $authenticated = false;
    public $OnyxSession;
    static $instance = null;
    public function __construct(){
        //$this->salt = IonyxAuthenticate::salt;
        $this->OnyxSession = $this->GenerateUniqueId();
        define("BASE_URL", IonyxAuthenticate::OnyxUrl);
    }
    static function GetInstance(){
        
    }
    private function GenerateEncryptionKey(){
        $key = md5(IonyxAuthenticate::salt);
        $this->SetEncryptionKey($key);
        
    }
    public function GenerateUniqueId(){
        $this->checkCookies();
        if(isset($_SESSION['Onyx_session_id'])){
            return $_SESSION['Onyx_session_id'];
        }
        $seed = rand();
        $seed = bin2hex($seed).'onyx';
        $seed = str_ireplace('.', '', $seed);
        return $_SESSION['Onyx_session_id'] = str_shuffle(uniqid($seed, true));
    }
    public function checkCookies(){
        if(isset($_COOKIE['Onyx_session_id'])){
            $_SESSION['Onyx_session_id'] = $this->GetCookie('Onyx_session_id');       
        }
    }
    private function SetEncryptionKey($rawKey){
        $this->encryptionKey = $rawKey;
    }

    private function CheckEncryptionKey($inValue){
        if($inValue === $this->encryptionKey){
            return true;
        }
        return false;
    }
    public function Authenticate($eKey){
        $auth = $this->CheckEncryptionKey($eKey);
        if($auth){
            $this->authenticated = true;
        }
        return $this->authenticated;
    }
    public function AuthenticateInstall($eKey){
        $included_files = get_included_files();
        $pass = array();
        $required = array(
            'core.php',
            'OnyxUtilities.php',
            'onyx-loader.php'
        );
        foreach($included_files as $file){
            if(array_search(basename($file), $required) !== false){
                $pass[] = true;
            }    
        }
        if(count($pass) == 3){
            return $this->Authenticate($eKey);
        }
        return false;
        
    }
    public function getInstallUrl(){
        //return $_SERVER['PHP_SELF'] . '?installer=databaseSetup&auth='.$this->encryptionKey;
        return 'Onyx/install/?installer=setupDatabase&auth='.$this->encryptionKey;
    }
    private function encrypt($code){
        $iv = mcrypt_create_iv(16, MCRYPT_RAND);
        $ivCoded = base64_encode($iv);
        $encrypted = $iv.mcrypt_encrypt(MCRYPT_RIJNDAEL_128, md5(IonyxAuthenticate::salt), $code, MCRYPT_MODE_CBC, $iv);
        return base64_encode($encrypted);
    }
    public function login($usr, $psw){
        $code = $_SESSION['Onyx_session_id'];
        //get $_POST password and $_POST username if username is found grab the password and decrypt check against $_POST password
        //if($_post password == $this->decrypt($password from db)){ $_SESSION['Onyx_authorized'] = $this->encrypt($code);   } else{ //error}
        $_SESSION['Onyx_authorized'] = $this->encrypt($code);   
        header("LOCATION: admin");   
    }
    public function logout(){
        $_SESSION['Onyx_authorized'] = null;   
    }
    private function decrypt($code){
        $decrypt = base64_decode($code);
        $iv_dec = substr($decrypt, 0, 16);
        $decrypt = substr($decrypt, 16);
        $item = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, md5(IonyxAuthenticate::salt), $decrypt, MCRYPT_MODE_CBC, $iv_dec);
        return $item;
    }
    public function Authorized(){
        if(!isset($_SESSION['Onyx_authorized'])){
            return false;
        }
        if( trim( $_SESSION['Onyx_session_id'] ) == trim( $this->decrypt( $_SESSION['Onyx_authorized'] ) ) ){
            return true;
        }
        return false;
    }
    public function SetCookie($name, $value, $exp = null, $path = "/", $domain = ""){
        if(is_array($value)){
            $value = json_encode($value);   
        }
        setcookie($name, base64_encode($value), $exp, $path, $domain);
    }
    public function lockCookies(){
        if( isset($_SESSION['Onyx_session_id']) ){
            $this->SetCookie("Onyx_session_id", $_SESSION['Onyx_session_id'], time()+ 1209600);   
        }
    }
    public function GetCookie($name){
        if(isset($_COOKIE[$name])){
            $decoded = base64_decode($_COOKIE[$name]);
            return is_string($decoded) && is_array(json_decode($decoded, true)) ? json_decode($decoded) : $decoded;
        }
        return null;
    }
    public function SetSession($name, $value){
        $_SESSION[$name] = $value;
    }
    public function GetSession(){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return null;
    }
}
$onyxAuthenticate = new OnyxAuthenticate();