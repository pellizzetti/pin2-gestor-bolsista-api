<?php

use App\Controllers\UserController;

Flight::route('/', function () {
    echo 'api';
});

$UserController = new UserController();

Flight::route('/user/@id:[0-9]{5}', array($UserController, 'getUserId'));
Flight::route('GET /user/test', array($UserController, 'testModel'));
Flight::route('POST /user', array($UserController, 'testPost'));
