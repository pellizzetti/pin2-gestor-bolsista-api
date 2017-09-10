<?php

// Modo debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define diretórios
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('VENDOR_DIR', ROOT_DIR . '/vendor');

// Inclui autoload e as routas
require(VENDOR_DIR . '/autoload.php');
require(ROOT_DIR . '/app/routes.php');

class Bootstrap
{
    public static function run()
    {
        Flight::start();
    }
}
