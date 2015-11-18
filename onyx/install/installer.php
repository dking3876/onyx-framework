<?php 
if(!file_exists(BASE_PATH . 'settings/database/IonyxAuthenticate.php')){
    if(!isset($_SESSION['Onyx_install_base_url'])){
        $_SESSION['Onyx_install_base_url'] = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}
define("BASE_URL", $_SESSION['Onyx_install_base_url']);