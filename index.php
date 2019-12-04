<?php
set_error_handler('err_handler');
function err_handler($errno, $errstr, $errfile, $errline) {
    $date = date('Y-m-d H:i:s');
    $f = fopen('err_log.txt', 'a');
    $err = "[$date]:  $errstr in $errfile on line $errline\r\n";
    fwrite($f, $err);
    fclose($f);
}

include("head.html");
include("main_header.html");
include("main.php");
include("footer.html");
include("foot.html");