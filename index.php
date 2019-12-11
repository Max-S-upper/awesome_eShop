<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

set_error_handler('err_handler');
function err_handler($errno, $errstr, $errfile, $errline) {
    $date = date('Y-m-d H:i:s');
    $f = fopen('err_log.txt', 'a');
    $err = "[$date]:  $errstr in $errfile on line $errline\r\n";
    fwrite($f, $err);
    fclose($f);
}

define('ROOT', dirname(__FILE__));
require_once (ROOT.'/application/components/Router.php');

$routes = new Router();
$routes->run();