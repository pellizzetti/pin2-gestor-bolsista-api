<?php

namespace App\Entities;

class User extends \Spot\Entity
{
    protected static $table = 'users';

    public static function fields()
    {
        return [
            'id'         => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'name'       => ['type' => 'string', 'required' => true],
            'email'      => ['type' => 'string', 'required' => true],
            'password'   => ['type' => 'string', 'required' => true],
            'created_at' => ['type' => 'datetime', 'value' => new \DateTime()],
            'updated_at' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }
}
