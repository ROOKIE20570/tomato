<?php

namespace App\Http\Controllers;

use App\Cost;
use Illuminate\Http\Request;

class CostController extends Controller
{
    //
    public function __construct(Cost $cost)
    {
        $this->model = $cost;
    }
}
