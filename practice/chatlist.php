<?php
session_start();
sleep(3);
header('Content-Type: application/json; charset=utf-8');
if(!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = array();
}
echo (json_encode($_SESSION['chat'], JSON_PRETTY_PRINT));