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

    public function checkInOut()
    {
        $request = \Flight::request();
        $data    = json_decode($request->getBody());

        if (property_exists($data, 'inOut') && property_exists($data, 'userId')) {
            $inOut  = $data->inOut;
            $userId = $data->userId;

            $mapper     = $this->spot->mapper($this->entity);
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
}
