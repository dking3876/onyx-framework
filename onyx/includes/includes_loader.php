<?php 
if(!file_exists(BASE_PATH . 'settings/database/IonyxAuthenticate.php')){
    $salt = str_shuffle(uniqid("onyxinstaller", true));
    $salt = str_ireplace('.', '', $salt);
    try{
        require BASE_PATH . 'settings/database/_IonyxAuthenticate.php';
    }catch(Exception $e){
        die('There appears to be a problem with your installation of Onyx.  The vital file <i>_IonyxAuthenticate.php</i> appears to be missing.  This file is required to continue with installation.  If you have already installed Onyx on your system and are seeing this message, required credentail files are missing.<br/> <blockquote>Error message: #X1786fi6</blockquote>');
    }
}
include_once ONYX_PATH . 'model/error_test.php';
include_once ONYX_PATH . 'model/arrayutils.php';
include_once ONYX_PATH . 'model/OnyxAuthenticate.php';