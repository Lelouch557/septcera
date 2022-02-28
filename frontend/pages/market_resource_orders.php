<?php
session_start();
$required = [
    '../backend/header',
    '../backend/general.config',
    '../backend/basic_functions',
    '../backend/market'
];

foreach($required as $link){
    require_once($link.".php");
}
$header = Header::getHeader(['header', 'chat', 'market']);
$market = new Market;


echo $header;
$orders = $market->get_orders($db, $_GET['resource_id']);
echo $orders;



?>