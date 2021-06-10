<?php
session_start();

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    if(isset($_POST['reset'])) {
        $_SESSION['chat'] = Array();
        header('Location: chat-index.php');
        return;
    }

    if(isset($_POST['message'])){
        if(!isset($_SESSION['chat'])) {
            $_SESSION['chat'] = Array();
        }
        $_SESSION['chat'][] = array($_POST['message'], date(DATE_RFC2822));
        header('Location: chat-index.php');
        return;
    }


}