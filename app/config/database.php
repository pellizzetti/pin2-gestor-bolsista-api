<?php

namespace App\Config;

function spot()
{
    static $spot;
    
    if($spot === null) {
        $cfg = new \Spot\Config();

        $cfg->addConnection('pgsql', [
            'dbname' => 'gestor-bolsista',
            'user' => 'gestor',
            'password' => 'secret',
            'host' => 'localhost',
            'driver' => 'pdo_pgsql',
        ]);

        // $mapper = $spot->mapper('App\Models\User');
        // $mapper->migrate();

        $spot = new \Spot\Locator($cfg);
    }

    return $spot;
}

function container()
{
    return DI\ContainerBuilder::buildDevContainer();
}
