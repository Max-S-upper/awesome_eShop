<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
use app\TransferCreator\TransferCreator;

$telegramData = array(
    "telegram" => array(
        "message" => "Here we go"
    )
);
$mailData = array(
    "mail" => array(
        "host" => "smtp.gmail.com",
        "port" => 465,
        "encryption" => "ssl",
        "username" => "maxim.sokolsky@gmail.com",
        "password" => "Maso88769202",
        "subject" => "Awesome subject",
        "fromEmail" => "maxim.sokolsky@gmail.com",
        "fromName" => "Max",
        "toEmail" => "totalgol2015@gmail.com",
        "toName" => "Me",
        "message" => "Here is my awesome message for myself:)"
    )
);
$telegram = new TransferCreator();
$telegram->send($telegramData);