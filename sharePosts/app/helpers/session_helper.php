<?php
session_start();
/*
##### The flash message do two things ######

1. SETTING SESSION IN A CERTAIN NAME AND ASSIGN message
2. DISPLAY IN VIEW - with alert message
*/

function flash($name='', $message='', $class="alert alert-success") {
    
    if(!empty($name)) {
        // setting session
        if(!empty($message) and empty($_SESSION[$name]) and empty($_SESSION[$name . '_class'])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }

        // display in view
        else if(empty($message) and !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name . '_class']) ? $class : '';
            echo '<div class="' . $class . '">' . $_SESSION[$name] . '</div>';

            unset($_SESSION[$name]);
            unset($_SESSION[$name. '_class']);
        }
    }
}

function isLoggedIn() {
    if(isset($_SESSION['user_name'])) {
        return true;
    }else{
        return false;
    }
}