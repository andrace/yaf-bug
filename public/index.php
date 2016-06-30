<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
//define('APPLICATION_PATH', dirname(__FILE__));
define('APPLICATION_PATH', dirname(__FILE__) . '/../');
define('APP_PATH', dirname(__FILE__) . '/../');


$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
