<?php

use App\Controllers\UserController;
use App\Controllers\CheckInOutController;

// Inicia controladores
$UserController       = new UserController($spot);
$CheckInOutController = new CheckInOutController($spot);
$AttendanceController = new AttendanceController($spot);

// Mapeia resposta para rotas não encontradas
Flight::map('notFound', function() {
    Flight::json(
        array(
            'message' => 'Rota não encontrada'
        ), 
        $code = 404
    );
});

// Rota pra ping test
Flight::route('/', function() {
    Flight::json(
        array(
            'message' => 'api'
        )
    );
});

// Rotas de usuário
Flight::route('GET /users', array($UserController, 'getUsers'));
Flight::route('GET /user/admin', array($UserController, 'createAdmin'));
Flight::route('POST /user', array($UserController, 'createUser'));
Flight::route('POST /user/login', array($UserController, 'loginByEmailAndPassword'));

// Rotas de check-in/out
Flight::route('POST /checkinout/@id:[0-9]{1,5}', array($CheckInOutController, 'checkInOut'));
Flight::route('GET /checkinout/list/@id:[0-9]{1,5}', array($CheckInOutController, 'getListCheckInOut'));

// Rotas de atendimento
Flight::route('GET /attendances', array($CheckInOutController, 'getListAttendance'));
Flight::route('POST /attendance', array($CheckInOutController, 'createAttendance'));
