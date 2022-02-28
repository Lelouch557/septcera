<?php
session_start();

$_SESSION = array();
unset($_COOKIE["PHPSESSID"]);
session_destroy();

header("Location: https://iabamun.nl/game/lab-andre/frontend/pages/account/login.php");
?>