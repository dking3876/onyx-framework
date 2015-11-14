<?php
define("BASE_PATH", dirname(realpath(__FILE__)).'/');

define("CORE_PATH", BASE_PATH .'onyx/');

define("ADMIN_PATH", BASE_PATH .'admin/');

define("ASSETS_PATH", BASE_PATH .'assets/');

define("PLUGINS_PATH", BASE_PATH .'plugins/');

define("DEBUG_MODE", TRUE);

if(!file_exists(BASE_PATH .'onyx/database/creds.php') && dirname(__FILE__) != 'install'){
    header('LOCATION:/install/');
}

include_once BASE_PATH .'onyx/core.php';