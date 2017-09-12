<?php

namespace App\Controllers;

class UserController
{
    private $user;

    public function __construct($spot)
    {
        $this->user = $spot->mapper('App\Models\User');
    }

    public function createAdmin()
    {
        try {
            $entity = $this->user->create([
                'email' => 'admin@admin.com',
                'password' => 'admin'
            ]);

            \Flight::json($entity);
        } catch (Exception $e) {
            echo 'Erro: ',  $e->getMessage(), "\n";
        }
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
