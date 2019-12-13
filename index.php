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

// My first composer package for educational purposes
//include 'vendor/autoload.php';
//include 'vendor/max-s-upper/my_first_smile_package/app/MyFirstPackage.php';
//use my_package\app\MyFirstPackage;
//class testPackage extends MyFirstPackage {}
//$test1 = new testPackage('test1');
//echo $test1->customGetProcessor();


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