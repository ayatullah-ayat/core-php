<?php
// include_once('../app/libraries/Core.php');
// include_once('../app/libraries/Controller.php');

include_once('config/config.php');
include_once('helpers/url_helper.php');
include_once('helpers/session_helper.php');
// include all libraries class at once
spl_autoload_register(function($className) {
    include_once('libraries/' . $className . '.php');
});