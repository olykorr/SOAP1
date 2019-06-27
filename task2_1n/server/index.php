<?php
include 'libs/config.php';
include 'libs/function.php';
include 'libs/Cars.php';

ini_set("soap.wsdl_cache_enabled", "0");

$server = new SoapServer("mySoapNew.wsdl");
$server->setClass("Cars");
$server->handle();






