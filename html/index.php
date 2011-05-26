<?php
$start = microtime(true);
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1); 
ini_set('error_log', 'logs/php-error.log');
header('Content-Type: text/html; charset=ISO-8859-1; Expires: Sat, 26 Jul 1997 05:00:00 GMT; Cache-Control: no-cache, must-revalidate; pragma: no-cache');
$base = str_replace('/html', '', getcwd());
require_once($base.'/base/session.php');
require_once($base.'/base/security.php');
require_once($base.'/base/request.php');
require_once($base.'/base/database.php');
require_once($base.'/base/response.php');
request::execute();
ob_flush();
$stop = microtime(true);
request::log($stop-$start);
?>