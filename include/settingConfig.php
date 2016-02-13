<?php

define('APP_PATH', str_replace('\\', '/', substr(dirname(__FILE__),0,strlen(dirname(__FILE__))-8 )));
define('WEB_PATH',"http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]."/..");
define("PAGE_NAME", basename($_SERVER['PHP_SELF'],'.php'));

date_default_timezone_set("Asia/Taipei");

include_once APP_PATH.'/include/DBConfig.php';
include_once APP_PATH.'/include/function/pubilc_fun.php';
include_once APP_PATH.'/include/function/db_fun.php';
include_once APP_PATH.'/include/baziPhotoClass.php';

?>