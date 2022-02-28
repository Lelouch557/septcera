<?PHP
session_start();
$required = [
    '../backend/header',
    '../backend/general.config',
    '../backend/basic_functions'
];

foreach($required as $link){
    require_once($link.".php");
}

echo Header::getHeader(['header', 'chat']);


?>