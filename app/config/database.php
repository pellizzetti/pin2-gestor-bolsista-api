<?php

try {
    $cfg = new \Spot\Config();
    
    $cfg->addConnection('pgsql', [
        'dbname' => 'gestor-bolsista',
        'user' => 'gestor',
        'password' => 'secret',
        'host' => 'localhost',
        'driver' => 'pdo_pgsql',
    ]);

    $spot = new \Spot\Locator($cfg);

    $mapper = $spot->mapper('App\Entities\User');
    $mapper->migrate();
} catch (Exception $e) {
    $summary = 'Erro ao tentar se conectar com o banco de dados, verifique a configuração';
    $err     = $e->getMessage();
    
    \Flight::json(
        array(
            'summary' => $summary,
            'err'     => $err
        ),
        $code = 401
    );
}