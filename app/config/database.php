<?php

$cfg = new \Spot\Config();

$cfg->addConnection('pgsql', [
    'dbname' => 'gestor',
    'user' => 'meucrediario',
    'password' => 'elefante',
    'host' => 'localhost',
    'driver' => 'pdo_pgsql',
]);

$spot = new \Spot\Locator($cfg);

$mapper = $spot->mapper('App\Entities\User');
$mapper->migrate();
