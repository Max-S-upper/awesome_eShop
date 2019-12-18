<?php
namespace awesome_eShop;

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

ini_set('display_errors', 1);
error_reporting(E_ALL);

set_error_handler('awesome_eShop\err_handler');
function err_handler($errstr, $errfile, $errline) {
    $date = date('Y-m-d H:i:s');
    $f = fopen('err_log.txt', 'a');
    $err = "[$date]:  $errstr in $errfile on line $errline\r\n";
    fwrite($f, $err);
    fclose($f);
}

//include 'vendor/autoload.php';
//use my_package\app\LogsToTelegram;
//use Monolog\Handler\StreamHandler;
//use Monolog\Logger;
//
//class testPackage extends LogsToTelegram {}
//$test1 = new testPackage('test1');
//$test1->info('This is a log! ^_^ ');
//$test1->warning('This is a log warning! ^_^ ');
//$test1->error('This is a log error! ^_^ ');


spl_autoload_register(function ($className) {
    $classArr = explode('\\', $className);
    $class = array_pop($classArr);
    $subPath = strtolower(implode(DS, $classArr));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if (file_exists($path)) {
        require_once($path);
    }
});

use application\components\Router;

$routes = new Router();
$routes->run();