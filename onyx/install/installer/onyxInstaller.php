<?php 
class OnyxInstaller {

    public function Icreds(){
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
    
    public function IonyxAuthenticate(){
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
}
$onyxInstaller = new OnyxInstaller();