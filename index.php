<?php 
session_start();
define('BP',__DIR__ . DIRECTORY_SEPARATOR);

error_reporting(E_ALL);
ini_set('display_errors',1);


$t=implode(PATH_SEPARATOR, 
        [

            BP . 'model',
            BP . 'controller'

        ]
        );

set_include_path($t);
spl_autoload_register(function($class)
{

    $paths= explode(PATH_SEPARATOR, get_include_path());
    foreach($paths as $p){
        if(file_exists($p . DIRECTORY_SEPARATOR . $class . '.php')){
            include $p . DIRECTORY_SEPARATOR . $class . '.php';
            break;
        }
    }

});

//require_once 'vendor/autoload.php';
App::start();