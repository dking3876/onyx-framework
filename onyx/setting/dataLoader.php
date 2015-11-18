<?php
include_once ONYX_PATH . 'model/OnyxAuthenticate.php';
require_once ONYX_PATH . 'setting/database/connect.php';
require_once ONYX_PATH . 'setting/database/datastructure.php';

foreach(glob(ONYX_PATH . "setting/database/tables/*_table.php") as $filename){
    include_once $filename;
    $file = explode('.',basename($filename));
    if(class_exists($file[0])){
        $instantiate = new $file[0]();
    }
}
foreach(glob(BASE_PATH . "setting/database/tables/*_table.php") as $filename){
    include_once $filename;
    $file = explode('.',basename($filename));
    if(class_exists($file[0])){
        $instantiate = new $file[0]();
    }
}