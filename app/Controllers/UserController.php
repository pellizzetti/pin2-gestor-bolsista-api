<?php

namespace App\Controllers;

use Spot\Locator;

class UserController extends Controller
{
    public function __construct(Locator $spot)
    {
        parent::__construct($spot);
        $this->entity = 'App\Entities\User';
    }

    public function createAdmin()
    {
        try {
            $mapper = $this->spot->mapper($this->entity);
            $user = $mapper->create([
                'email'    => 'admin@admin.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT)
            ]);

            \Flight::json($user);
        } catch (Exception $e) {
            echo 'Erro: ',  $e->getMessage(), "\n";
        }
    }

    public function loginByEmailAndPassword()
    {
        $request = \Flight::request();
        $data    = json_decode($request->getBody());

        if (property_exists($data, 'email') && property_exists($data, 'password')) {
            $userEmail     = $data->email;
            $userPassword  = $data->password;

            $mapper = $this->spot->mapper($this->entity);
            $user = $mapper->first(['email' => $userEmail]);

            if ($user) {
                $hashPassword = isset($user->password) ? $user->password : '';
                if (password_verify($userPassword, $hashPassword)) {
                    \Flight::json(
                        array(
                            'auth' => true,
                            'msg' => 'Autenticado com sucesso'
                        )
                    );
                }
            }

            \Flight::json(
                array(
                    'auth' => false,
                    'msg' => 'E-mail ou senha inválidos'
                ),
                $code = 401
            );
        }

        \Flight::json(
            'Servidor não pode entender a requisição por se tratar de um sintaxe inválida para essa rota',
            $code = 400
        );
    }
}
