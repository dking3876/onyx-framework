<?php 
include_once ONYX_PATH . 'model/OnyxAuthenticate.php';
class OnyxInstaller extends OnyxController {
    
    private $installationStage;
    
    private $authKey;
    
    public function __construct($stage = null){
        echo 'construct';
        $this->installationStage = $stage ? $stage : $_GET['installer'];
        $this->authKey = $_GET['auth'];
        $method = "Onyx{$this->installationStage}";
        $this->$method();
    }
    static function Icreds(){
        $creds = $_REQUEST['creds'];
        $Icreds = "<?php
/* 
 * Credential Interface
 */
interface Icreds{
    const HOST = '{$creds['HOST']}';
    const USER = '{$creds['USER']}';
    const PASS = '{$creds['PASSWORD']}';
    const DB = '{$creds['DATABASE']}';
    const ENV = '{$creds['ENVIORMENT']}';
}
";
        $fp=fopen(BASE_PATH . 'settings/database/creds.php', 'w');
        fwrite($fp, $Icreds);
        fclose($fp);
    }
    
    static function IonyxAuthenticate(){
        $salt = str_shuffle(uniqid("onyxinstaller", true));
        $salt = str_ireplace('.', '', $salt);
        $Icreds = "<?php
interface IonyxAuthenticate {

    const salt = '{$salt}';
}
";
        $fp=fopen(BASE_PATH . 'settings/database/IonyxAuthenticate.php', 'w');
        fwrite($fp, $Icreds);
        fclose($fp);
    }
    
    private function OnyxdatabaseSetup(){
        echo 'Asking for database information';
        $this->view($this->installationStage, ONYX_PATH);
    }
    
    private function OnyxInstallDatabase(){
        if(!isset($_POST[''])){
            return false;   
        }
    }
    private function Onyxappsettings(){
        if(!$this->OnyxInstallDatabase()){
            return;
        }
    }
}