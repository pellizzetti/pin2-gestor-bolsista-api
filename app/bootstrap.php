<?php

// Modo debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define raiz da aplicação
define('ROOT_DIR', dirname(dirname(__FILE__)));

// Inclui autoload, config do bd e rotas
require(ROOT_DIR . '/vendor/autoload.php');
require(ROOT_DIR . '/app/config/database.php');
require(ROOT_DIR . '/app/routes.php');

class Bootstrap
{
    public static function run()
    {
        Flight::start();
    }
}