<?php
//require_once ONYX_PATH . 'setting/database/connect.php';
require_once ONYX_PATH . 'setting/database/datastructure.php';

$connection = OnyxConnectionService::getInstance();
foreach(glob(ONYX_PATH . "setting/database/tables/*_table.php") as $filename){
    //include_once $filename;
    $file = explode('.',basename($filename));
    if(class_exists($file[0])){
        $instantiate = new $file[0]($connection);
    }
}
foreach(glob(BASE_PATH . "settings/database/tables/*_table.php") as $filename){
    //include_once $filename;
    $file = explode('.',basename($filename));
    if(class_exists($file[0])){
        $instantiate = new $file[0]($connection);
    }
}