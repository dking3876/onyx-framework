<?php 
class OnyxInstallModel extends OnyxModel {
    
    public function main(){
        
    }
    private function Icreds(){
        $creds = $_POST;
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
        if(fwrite($fp, $Icreds)){
            return fclose($fp);
        }
        return false;;
    }
    public function GenerateCreds(){
        return $this->Icreds();   
    }
    private function IonyxAuthenticate($salt){
        $OnyxUrl = $_SESSION['Onyx_install_base_url'];
        $Icreds = "<?php
interface IonyxAuthenticate {

    const salt = '{$salt}';
    const OnyxUrl = '{$OnyxUrl}';
}
";
        $fp=fopen(BASE_PATH . 'settings/database/IonyxAuthenticate.php', 'w');
        if(fwrite($fp, $Icreds)){
            return fclose($fp);
        }
    }
    public function GenerateSalt(){
        $salt = str_shuffle(uniqid("onyxinstaller", true));
        $salt = str_ireplace('.', '', $salt);
        if($this->IonyxAuthenticate($salt)){
            return $salt;
        }        
        return false;
    }
    public function CheckSystemHealth(){
        $mysql = extension_loaded("mysql")? 'pass': 'fail';
        $curl = function_exists("curl_init")? 'pass': 'fail';
        $writable = is_writable(BASE_PATH)? 'pass': 'fail';
        $mail = mail("deryk@royaltydesignstudios.com", "mailtest", "Testing status of mail function")? 'pass': 'fail';
        $dependancies = array(
            "mysql" => $mysql,
            "curl" => $curl,
            "writeable" => $writable,
            "mail" => $mail
        );
        $continueStatus = '';
        foreach($dependancies as $item => $status){
            if($status == 'fail'){
                $continueStatus = 'disabled';
            }
        }
        $dependancies['continueStatus'] = $continueStatus;
        $this->Onyx->viewData($dependancies); 
    }
}