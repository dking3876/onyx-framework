<?php 
define("ONYX_VERSION", 0.1);

define("ASSETS_PATH", BASE_PATH .'assets/');

define("EXTENSIONS_PATH", BASE_PATH .'extensions/');

define("ONYX_PATH", BASE_PATH .'onyx/');

define("DATA_PATH", BASE_PATH . 'data/');

include_once ONYX_PATH . 'includes/OnyxUtilities.php';

include_once ONYX_PATH . 'includes/OnyxErrorHandler.php';

include_once ONYX_PATH . 'includes/OnyxFunctions.php';

if(!file_exists(BASE_PATH . 'settings/database/IOnyxCreds.php')){
    include_once ONYX_PATH . 'includes/OnyxInstaller.php';
    if(!isset($_GET['installer'])){
        header("LOCATION:".$_SESSION['Onyx_install_base_url']."Onyx/install/?installer");
    }
}
OnyxAppController::GetInstance();