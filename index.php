<?php 
try{
    require_once 'onyx-loader.php';
}catch (Exception $e){
    OnyxErrorHandler::OnyxError($e);
    die('Can not load required files');
}
