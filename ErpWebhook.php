<?php
//Adicionar a raiz da loja permite testar com a url <loja>/ErpWebhook.php o request do modulo
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('app/Mage.php');
umask(0);

Mage::app();

$data = file_get_contents('php://input');
Mage::log(getallheaders(), null, "Request.log", true);
Mage::log($data, null, "Request.log", true);