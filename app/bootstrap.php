<?php

// require_once 'libraries/Core.php';
// require_once 'libraries/Controller.php';
// require_once 'libraries/Database.php';


function autoloading($className)
{
    
    require_once 'libraries/' . $className . '.php';
}

spl_autoload_register('autoloading');
