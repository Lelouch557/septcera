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
$values = $market->get_values($db);
echo $values;



?>