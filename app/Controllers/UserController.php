<?php

namespace App\Controllers;

use Spot\Locator;
use Firebase\JWT\JWT;

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
                    // TO-DO: Desenvolver um meio de gerar isso por comando e colocar em um arquivo de 
                    // varíaveis de ambiente || '62E28F22E6E269'
                    $key = 'd9c993c4678855873a8f95645a9c9cbe41cee9f79ab5ff998ec669f1cd951733';
                    
                    $token = array(
                        'sub' => $user->name,
                        'context' => array(
                            'user' => array(
                                'userId'    => $user->id,
                                'userName'  => $user->email,
                                'userLevel' => 'admin'
                            )
                        ),
                        'iss' => 'ceavi-udesc',
                        'iat' => time(), // Emitido em...
                        'exp' => time() + 6 * 24 * 60 * 60 // Expira em...
                    );
                    
                    $jwt = JWT::encode($token, $key, 'HS256');
            
                    \Flight::json(
                        array(
                            'auth' => true,
                            'msg'  => 'Autenticado com sucesso',
                            'jwt'  => $jwt
                        )
                    );
                }
            }

            \Flight::json(
                array(
                    'auth' => false,
                    'msg'  => 'E-mail ou senha inválidos'
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
