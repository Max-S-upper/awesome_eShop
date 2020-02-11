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
        "username" => "test@gmail.com",
        "password" => "password",
        "subject" => "subject",
        "fromEmail" => "from@gmail.com",
        "fromName" => "Max",
        "toEmail" => "reciever@gmail.com",
        "toName" => "Me",
        "message" => "Here is my awesome message for myself:)"
    )
);
$telegram = new TransferCreator();
$telegram->send($telegramData);
