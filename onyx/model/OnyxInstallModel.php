<?php 
class OnyxInstallModel extends OnyxModel {
    
    public function main(){
        
    }
    private function Icreds(){
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
        $this->Onyx->viewData(array('test' => 'hello', 'test1' => 'goodbye'));
        if($this->IonyxAuthenticate($salt)){
            return $salt;
        }        
        return false;
    }
    public function CheckSystemHealth(){
        //check if fopen ok check for needed functions like curl, file_get_contents, allow_url_fopen, http_post_data, new HTTPRequest() , disk is writtable check for mysql, pdo capabilities, use extenstion_loaded to check for php libs
    }
}