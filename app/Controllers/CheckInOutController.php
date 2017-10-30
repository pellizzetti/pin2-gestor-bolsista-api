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
}
