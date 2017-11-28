<?php

namespace App\Controllers;

use Spot\Locator;
use Firebase\JWT\JWT;

class ResearchReportController extends Controller
{
    public function __construct(Locator $spot)
    {
        parent::__construct($spot);
        $this->entity = 'App\Entities\ResearchReport';
    }

    public function createResearchReport()
    {
        $request = \Flight::request();
        $data    = json_decode($request->getBody());

        if (property_exists($data, 'description') && property_exists($data, 'userId')) {
            $researchReportDescription = $data->description;
            $userId                    = $data->userId;

            try {
                $mapper         = $this->spot->mapper($this->entity);
                $researchReport = $mapper->create([
                    'description' => $attendanceDescription,
                    'user_id'     => $userId
                ]);

                return \Flight::json(
                    array(
                        'success'        => true,
                        'message'        => 'Relatório de pesquisa criado com sucesso',
                        'researchReport' => $attendance
                    )
                );
            } catch (\Spot\Exception $e) {
                return \Flight::json(
                    array(
                        'success' => false,
                        'error'   => 'Erro ao criar Relatório de pesquisa',
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

    public function getListResearchReport()
    {
        $dayWeek            = Date('N');
        $daysToEnd          = 7 - $dayWeek;
        $daysFromStart      = $dayWeek - 1;
        $weekStart          = new \DateTime("- {$daysFromStart} days");
        $weekEnd            = new \DateTime("+ {$daysToEnd} days");
        $mapper             = $this->spot->mapper($this->entity);
        $researchReportList = $mapper->where([
            'created_at >=' => $weekStart->format('Y-m-d H:i:s'),
            'created_at <=' => $weekEnd->format('Y-m-d H:i:s'),
        ])->order(['created_at' => 'asc']);
            
        if ($researchReportList) {
            return \Flight::json(
                array(
                    'success'            => true,
                    'message'            => 'Lista de relatórios de pesquisa retornada com sucesso',
                    'researchReportList' => $researchReportList
                )
            );
        } 

        return \Flight::json(
            array(
                'success'            => false,
                'message'            => "Nenhum relatório de pesquisa encontrado",
                'researchReportList' => []
            ),
            $code = 401
        );
    }
}
