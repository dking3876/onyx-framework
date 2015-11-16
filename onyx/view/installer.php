<?php 
//include_once BASE_PATH.'onyx-loader.php';
if(!$onyxAuthenticate->AuthenticateInstall($_GET['auth'])){
    die('You have attempted to access a secured location you do not appear to have permission to Access.  If you beleive you are seeing this message in error please contact the Site Administrator');
}
if(file_exists(BASE_PATH.'settings/database/Icreds.php')){
    die('You have attempted to install the Onyx Framework.  We have detected there is already a previous installation of this application. If you need to install or reinstall this application please delete your credential file.');
}
echo 'installer page';