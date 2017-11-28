<?php

try {
    $cfg   = new \Spot\Config();
    $dbCfg = parse_url(getenv('DATABASE_URL'));
    
    $cfg->addConnection('pgsql', [
        'dbname'   => ltrim($dbCfg['path'],'/'),
        'user'     => $dbCfg['user'],
        'password' => $dbCfg['pass'],
        'host'     => $dbCfg['host'],
        'port'     => $dbCfg['port'],
        'driver'   => 'pdo_pgsql',
    ]);

    $spot = new \Spot\Locator($cfg);

    $mapper = $spot->mapper('App\Entities\User');
    $mapper->migrate();

    $mapper = $spot->mapper('App\Entities\CheckInOut');
    $mapper->migrate();

    $mapper = $spot->mapper('App\Entities\Attendance');
    $mapper->migrate();
} catch (Exception $e) {   
    throw \Flight::json(
        array(
            'error'   => 'Erro ao conectar ao banco de dados',
            'message' => $e->getMessage()
        ),
        $code = 500
    );
} catch (\Spot\Exception $e) {
    throw \Flight::json(
        array(
            'error'            => 'Erro ao conectar ao banco de dados',
            'UserListResponse' => $e->getMessage()
        ),
        $code = 500
    );
}