<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function getUserId($id)
    {
        echo $id;
    }

    public function testModel()
    {
        echo $this->user->getMyUser();
    }

    public function loginByUserAndPassword()
    {
        $request = \Flight::request();
        $data    = json_decode($request->getBody());

        if (property_exists($data, 'email') && property_exists($data, 'password')) {
            $userEmail = $data->email;
            $userPass  = $data->password;

            \Flight::json('Autenticado! :D');
        }

        \Flight::json(
            'Servidor não pode entender a requisição por se tratar de um sintaxe inválida para essa rota',
            $code = 400
        );
    }
}
