<?php

namespace App\Controllers;

use Spot\Locator;
use Firebase\JWT\JWT;

class CheckInOutController extends Controller
{
    public function __construct(Locator $spot)
    {
        parent::__construct($spot);
        $this->entity = 'App\Entities\CheckInOut';
    }

    public function checkInOut($userId)
    {
        if ($userId) {
            $mapper = $this->spot->mapper($this->entity);
            $user   = $mapper->where(['user_id' => $userId])->order(['created_at' => 'DESC'])->first();
            
            if ($user) {
                $inOut = $user->in_out === 'in' ? 'out' : 'in';
            } else {
                $inOut = 'in';
            }

            $checkInOut = $mapper->create([
                'in_out'  => $inOut,
                'user_id' => $userId
            ]);
                
            return \Flight::json(
                array(
                    'checked'    => true,
                    'msg'        => "Check-{$inOut} realizado com sucesso",
                    'checkInOut' => $checkInOut
                )
            );
        }

        return \Flight::json(
            'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota',
            $code = 400
        );
    }

    public function listCheckInOut($userId)
    {
        if ($userId) {
            $hoje           = new \DateTime();
            $mapper         = $this->spot->mapper($this->entity);
            $checkInOutList = $mapper->where([
                'user_id'    => $userId,
                'created_at' => $hoje->format('Y-m-d')
            ])->order(['created_at' => 'asc']);
                
            if ($checkInOutList) {
                return \Flight::json(
                    array(
                        'success'        => true,
                        'msg'            => 'Lista de check-in/out retornada com sucesso',
                        'checkInOutList' => $checkInOutList
                    )
                );
            } 
            return \Flight::json(
                array(
                    'success' => false,
                    'msg'     => "Nenhum check-in/out encontrado",
                ),
                $code = 401
            );
        }

        return \Flight::json(
            'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota',
            $code = 400
        );
    }
}
