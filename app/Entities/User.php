<?php

namespace App\Entities;

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
}
