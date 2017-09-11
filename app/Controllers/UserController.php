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

    public function testPost()
    {
        $request = \Flight::request();
        $data = json_decode($request->getBody());

        echo "E-mail: $data->email
            Senha: $data->password";
    }
}
