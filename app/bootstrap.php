<?php

// Modo debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define raiz da aplicação
define('ROOT_DIR', dirname(dirname(__FILE__)));

// Inclui autoload, rotas e config do bd
require(ROOT_DIR . '/vendor/autoload.php');
require(ROOT_DIR . '/app/routes.php');
require(ROOT_DIR . '/app/config/database.php');

class Bootstrap
{
    public static function run()
    {
        Flight::start();
    }
}
