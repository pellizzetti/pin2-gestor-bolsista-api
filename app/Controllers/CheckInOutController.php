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
                
            \Flight::json(
                array(
                    'checked'    => true,
                    'msg'        => "Check-{$inOut} realizado com sucesso",
                    'checkInOut' => $checkInOut
                )
            );
        }

        \Flight::json(
            'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota',
            $code = 400
        );
    }

    public function listCheckInOut($userId)
    {
        if ($userId) {
            $mapper         = $this->spot->mapper($this->entity);
            $checkInOutList = $mapper->where(['user_id' => $userId])->order(['created_at' => 'DESC']);
                
            if ($checkInOutList) {
                \Flight::json(
                    array(
                        'success'        => true,
                        'msg'            => 'Lista de check-in/out retornada com sucesso',
                        'checkInOutList' => $checkInOutList
                    )
                );
            } else {
                \Flight::json(
                    array(
                        'success' => false,
                        'msg'     => "Usuário não encontrado",
                    ),
                    $code = 401
                );
            }
        }

        \Flight::json(
            'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota',
            $code = 400
        );
    }
}
