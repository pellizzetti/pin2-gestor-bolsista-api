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
        $this->spot = $spot;
    }
}
