<?php 
$path = realpath(dirname(__FILE__));
$path = explode('\\', $path);
array_pop($path);
$path = implode('\\', $path).'/onyx-loader.php';
require_once $path;