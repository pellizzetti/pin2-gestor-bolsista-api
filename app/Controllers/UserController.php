<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    private $user;

    public function __construct()
    {
        //$this->user = $spot->mapper('App\Models\User');
        $this->user = Config\config\container()->get('User');
    }

    public function createAdmin()
    {
        try {
            $entity = $this->user->create([
                'email'    => 'admin@admin.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT)
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
            $userEmail     = $data->email;
            $userPassword  = $data->password;
            
            \Flight::json($this->user->loginByUserAndPassword($userEmail, $userPassword));;
        }

        \Flight::json(
            'Servidor não pode entender a requisição por se tratar de um sintaxe inválida para essa rota',
            $code = 400
        );
    }
}
