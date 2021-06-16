<?php
// include_once('../app/libraries/Core.php');
// include_once('../app/libraries/Controller.php');

include_once('config/config.php');

spl_autoload_register(function($className) {
    include_once('libraries/' . $className . '.php');
});