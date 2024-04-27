<?php

// require_once 'libraries/Core.php';
// require_once 'libraries/Controller.php';
// require_once 'libraries/Database.php';
require_once 'config/config.php';
require_once 'helper/url_helper.php';
require_once 'helper/session_helper.php';


function autoloading($className)
{
    
    require_once 'libraries/' . $className . '.php';
}

spl_autoload_register('autoloading');
