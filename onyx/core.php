<?php 
define("ONYX_VERSION", 0.1);

define("ASSETS_PATH", BASE_PATH .'assets/');

define("PLUGINS_PATH", BASE_PATH .'plugins/');

if(!file_exists(BASE_PATH . 'setting/database/Icreds.php')){
    require_once ONYX_PATH . 'includes/includes_loader.php';
    if(!isset($_GET['installer'])){
        header("LOCATION:".$onyxAuthenticate->getInstallUrl());
    }else{
        include ONYX_PATH . 'install/installer.php';
    }
}else{
    require_once ONYX_PATH . 'setting/database/dataLoader.php';
}