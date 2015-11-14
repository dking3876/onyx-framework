<?php 
define("ONYX_VERSION", 0.1);

define("ASSETS_PATH", BASE_PATH .'assets/');

define("PLUGINS_PATH", BASE_PATH .'plugins/');

if(!file_exists(CORE_PATH . 'setting/database/Icreds.php')){
    if(dirname(__FILE__) != 'install'){
        header('LOCATION:/install/');
    }
    require_once CORE_PATH . 'include/scripts.php';
}else{
    require_once CORE_PATH . 'setting/database/dataLoader.php';
}

