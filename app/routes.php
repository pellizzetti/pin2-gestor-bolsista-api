<?php

use App\Controllers\UserController;

// Mapeia resposta para rotas não encontradas
Flight::map('notFound', function(){
    Flight::json('Rota não encontrada', $code = 404);
});

Flight::route('/', function () {
    echo 'api';
});

$UserController = new UserController($spot);

Flight::route('/user/@id:[0-9]{5}', array($UserController, 'getUserId'));
Flight::route('GET /user/test', array($UserController, 'testModel'));
Flight::route('GET /user/create/admin', array($UserController, 'createAdmin'));

Flight::route('POST /login', array($UserController, 'loginByUserAndPassword'));