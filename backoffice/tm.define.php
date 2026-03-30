<?php
session_start();
define('HOST', 'localhost');
define('HOST_USER', 'vscoffice_db');
define('HOST_PASSWORD', 'ojcXLV34lharp7');
define('HOST_DATABASE', 'vscoffice_db');
## Table ##
define('DB_PREFIX', 'slip_');
define('PAGEADMIN', 'backoffice.php');
define('WEB_PROJECT', 'PAY SLIP');

## Path ##

define('SYSTEM_PATH', '');
define('MODEL_PATH', 'model');
define('TEMPLATES_PATH', 'templates');
define('LOG_PATH', 'logs');
## URL ##

define('BASE_URL', '');
ini_set("log_errors", "0");
ini_set("error_log", "logs/log-php-" . date('Y-m-d') . ".txt");

require 'general.php';
require 'model/class.database.php';
require 'model/class.upload.php';
//require MODEL_PATH . DS . 'datethai' . EXT;
$db = new database();
