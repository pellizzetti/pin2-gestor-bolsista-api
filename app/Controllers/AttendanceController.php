<?php

namespace App\Controllers;

use Spot\Locator;
use Firebase\JWT\JWT;

class AttendanceController extends Controller
{
    public function __construct(Locator $spot)
    {
        parent::__construct($spot);
        $this->entity = 'App\Entities\Attendance';
    }

    public function createAttendance()
    {
        $request = \Flight::request();
        $data    = json_decode($request->getBody());

        if (
            property_exists($data, 'student') &&
            property_exists($data, 'description') &&
            property_exists($data, 'userId')
        ) {
            $attendanceStudent     = $data->student;
            $attendanceDescription = $data->description;
            $userId                = $data->userId;

            try {
                $mapper     = $this->spot->mapper($this->entity);
                $attendance = $mapper->create([
                    'student'     => $attendanceStudent,
                    'description' => $attendanceDescription,
                    'user_id'     => $userId
                ]);

                return \Flight::json(
                    array(
                        'success'    => true,
                        'message'    => 'Atendimento criado com sucesso',
                        'attendance' => $attendance
                    )
                );
            } catch (\Spot\Exception $e) {
                return \Flight::json(
                    array(
                        'success' => false,
                        'error'   => 'Erro ao criar atendimento',
                        'message' => $e->getMessage()
                    ),
                    $code = 500
                );
            }
        }

        return \Flight::json(
            array(
                'success' => false,
                'message' => 'Servidor não pode entender a requisição por se tratar de uma sintaxe inválida para essa rota'
            ),
            $code = 400
        );
    }

    public function getListAttendance()
    {
        $hoje           = new \DateTime('today');
        $amanha         = new \DateTime('tomorrow');
        $mapper         = $this->spot->mapper($this->entity);
        $attendanceList = $mapper->where([
            'created_at >=' => $hoje->format('Y-m-d H:i:s'),
            'created_at <'  => $amanha->format('Y-m-d H:i:s'),
        ])->order(['created_at' => 'asc']);
            
        if ($attendanceList) {
            return \Flight::json(
                array(
                    'success'        => true,
                    'message'        => 'Lista de atendimentos retornada com sucesso',
                    'attendanceList' => $attendanceList
                )
            );
        } 

        return \Flight::json(
            array(
                'success'        => false,
                'message'        => "Nenhum atendimento encontrado",
                'attendanceList' => []
            ),
            $code = 401
        );
    }
}
