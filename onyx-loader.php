<?php
/** 
 * Onyx Constant definitions
 * 
 * Sets all the needed constants for the Onyx Frameword to operate.
 * You can alternate between Debug Mode.  All Onyx settings are loaded and stored in 
 * the onyx/settings folder
 * 
 * @author Deryk W. King <dking3876@msn.com>
 * @version 0.1 DEV
 * 
 * 
 */ 
define("BASE_PATH", dirname(realpath(__FILE__)).'/');

define("ONYX_PATH", BASE_PATH .'onyx/');

define("ADMIN_PATH", BASE_PATH .'admin/');

define("DATA_PATH", BASE_PATH . 'data/');

define("DEBUG_MODE", true);

echo 'onyxloader.php';
require_once ONYX_PATH .'core.php';
