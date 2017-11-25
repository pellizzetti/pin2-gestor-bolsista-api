<?php

namespace App\Controllers;

use Spot\Locator;

abstract class Controller
{
    /**
     * @var \Spot\Locator
     */
    protected $spot;

    /**
     * @param Locator $spot
     */
    public function __construct(Locator $spot)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        $this->spot = $spot;
    }
}
