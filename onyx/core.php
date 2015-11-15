<?php 
define("ONYX_VERSION", 0.1);

define("ASSETS_PATH", BASE_PATH .'assets/');

define("PLUGINS_PATH", BASE_PATH .'plugins/');

if(!file_exists(ONYX_PATH . 'setting/database/Icreds.php')){
    if(dirname(__FILE__) != 'install'){
        header('LOCATION:/onyx/install/');
    }
    require_once ONYX_PATH . 'includes/includes_loader.php';
}else{
    require_once ONYX_PATH . 'setting/database/dataLoader.php';
}

