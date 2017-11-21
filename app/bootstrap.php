<?php

// Debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define raiz da aplicação
define('ROOT_DIR', dirname(dirname(__FILE__)));

// Define horário do servidor como brasileiro
date_default_timezone_set('America/Sao_Paulo');

// Inclui autoload, config do bd e rotas
require(ROOT_DIR . '/vendor/autoload.php');
require(ROOT_DIR . '/app/config/database.php');
require(ROOT_DIR . '/app/routes.php');

// Inicia api
class Bootstrap
{
    public static function run()
    {
        Flight::start();
    }
}
