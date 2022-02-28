<?php
//localhost
$user = 'deb118487_iabamun';
$pass = 'ZyAvvBc33U';
$host = 'localhost';
$dbname = 'deb118487_iabamun';

$db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>