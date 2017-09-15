<?php

namespace App\Models;

use Spot\MapperInterface as Mapper;

class User extends \Spot\Entity
{
    protected static $table = 'users';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'email'        => ['type' => 'string', 'required' => true],
            'password'     => ['type' => 'string', 'required' => true],
            'date_created' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }

    public static function loginByUserAndPassword(Mapper $mapper, $userEmail, $userPassword)
    {
        return $mapper->all()->where(['email' => $userEmail])->first();
    }
}
