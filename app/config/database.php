<?php

try {
    $cfg = new \Spot\Config();
    
    $cfg->addConnection('pgsql', [
        'dbname'   => 'gestor-bolsista',
        'user'     => 'gestor',
        'password' => 'secret',
        'host'     => 'localhost',
        'driver'   => 'pdo_pgsql',
    ]);

    $spot = new \Spot\Locator($cfg);

    $mapper = $spot->mapper('App\Entities\User');
    $mapper->migrate();

    $mapper = $spot->mapper('App\Entities\CheckInOut');
    $mapper->migrate();
} catch (Exception $e) {   
    \Flight::json(
        array(
            'error' => 'Erro ao criar usuário',
            'msg'   => $e->getMessage()
        ),
        $code = 500
    );
} catch (\Spot\Exception $e) {
    \Flight::json(
        array(
            'error' => 'Erro ao criar usuário',
            'msg'   => $e->getMessage()
        ),
        $code = 500
    );
}