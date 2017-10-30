<?php

use App\Controllers\UserController;
use App\Controllers\CheckInOutController;

// Inicia controladores
$UserController       = new UserController($spot);
$CheckInOutController = new CheckInOutController($spot);

// Mapeia resposta para rotas não encontradas
Flight::map('notFound', function() {
    Flight::json('Rota não encontrada', $code = 404);
});

// Rota pra ping test
Flight::route('/', function() {
    Flight::json('api');
});

// Rotas de usuário
Flight::route('/user/@id:[0-9]{5}', array($UserController, 'getUserId'));
Flight::route('GET /user/create/admin', array($UserController, 'createAdmin'));
Flight::route('POST /login', array($UserController, 'loginByEmailAndPassword'));
