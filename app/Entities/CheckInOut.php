<?php

namespace App\Entities;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class CheckInOut extends \Spot\Entity
{
    protected static $table = 'check_in_out';

    public static function fields()
    {
        return [
            'id'         => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'in_out'     => ['type' => 'string', 'required' => true],
            'user_id'    => ['type' => 'integer', 'required' => true],
            'created_at' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }

    public static function relations(Mapper $mapper, Entity $entity)
    {
        return [
            'user' => $mapper->belongsTo($entity, 'App\Entities\User', 'user_id')
        ];
    }
}
