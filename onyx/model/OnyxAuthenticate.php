<?php 
require_once BASE_PATH.'settings/database/IonyxAuthenticate.php';

final class OnyxAuthenticate implements IonyxAuthenticate {
    
    private $salt;
    private $encryptionKey;
    private $authenticated = false;
    
    public function __construct(){
        $this->salt = IonyxAuthenticate::salt;
        $this->GenerateEncryptionKey();
    }
    
    private function GenerateEncryptionKey(){
        $key = md5($this->salt);
        $this->SetEncryptionKey($key);
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
            'includes_loader.php',
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
        return 'install?installer=databaseSetup&auth='.$this->encryptionKey;
    }
}
$onyxAuthenticate = new OnyxAuthenticate();