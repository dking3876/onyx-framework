<?php 
try{
    require_once 'onyx-loader.php';
}catch (Exception $e){
    OnyxErrorHandler::OnyxError($e);
    //Handle for a major error
    die('Can not load required files');
}
