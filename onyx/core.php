<?php 
define("ONYX_VERSION", 0.1);

define("ASSETS_PATH", BASE_PATH .'assets/');

define("PLUGINS_PATH", BASE_PATH .'plugins/');

define("ONYX_PATH", BASE_PATH .'onyx/');

define("DATA_PATH", BASE_PATH . 'data/');

include_once ONYX_PATH . 'model/OnyxUtilities.php';

include_once ONYX_PATH . 'model/error_test.php';

include_once ONYX_PATH . 'controller/OnyxAppController.php';

include_once ONYX_PATH . 'model/OnyxModel.php';

include_once ONYX_PATH . 'install/installer.php';

if(!file_exists(BASE_PATH . 'setting/database/Icreds.php')){
    include_once ONYX_PATH . 'install/installer.php';
    if(!isset($_GET['installer'])){
        header("LOCATION:".$_SESSION['Onyx_install_base_url']."Onyx/install/?installer");
    }else{
        //include_once ONYX_PATH . 'controller/onyxInstaller.php';
    }
}else{
    require_once ONYX_PATH . 'setting/database/dataLoader.php';
}
OnyxAppController::GetInstance();
    