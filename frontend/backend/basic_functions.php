<?php
if(!isset($_SESSION['user_id'])){
    header('Location: https://iabamun.nl/game/lab-andre/frontend/pages/account/login.php');
}
?>