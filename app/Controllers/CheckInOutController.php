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
                    'message'    => "Check-{$inOut} realizado com sucesso",
                    'checkInOut' => $checkInOut
                )
            );
        }

        return \Flight::json(
            'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota',
            $code = 400
        );
    }

    public function getListCheckInOut($userId)
    {
        if ($userId) {
            $hoje           = new \DateTime('today');
            $amanha         = new \DateTime('tomorrow');
            $mapper         = $this->spot->mapper($this->entity);
            $checkInOutList = $mapper->where([
                'user_id'       => $userId,
                'created_at >=' => $hoje->format('Y-m-d H:i:s'),
                'created_at <'  => $amanha->format('Y-m-d H:i:s'),
            ])->order(['created_at' => 'asc']);
                
            if ($checkInOutList) {
                return \Flight::json(
                    array(
                        'success'        => true,
                        'message'        => 'Lista de check-in/out retornada com sucesso',
                        'checkInOutList' => $checkInOutList
                    )
                );
            } 
            return \Flight::json(
                array(
                    'success' => false,
                    'message' => "Nenhum check-in/out encontrado",
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
