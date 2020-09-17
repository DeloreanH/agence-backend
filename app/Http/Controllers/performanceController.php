<?php

namespace App\Http\Controllers;

use App\Models\caoFatura;
use App\Models\caoSalario;
use App\Http\Requests\reportsRequest;

class performanceController extends Controller
{

    public $caoFatura;
    public $caoSalario;

    public function __construct()
    {
        $this->caoFatura = new caoFatura();
        $this->caoSalario = new caoSalario();
    }

    /**
     * returns all necessary  user comercial peformance data to build reports, graph and pizza graph
     * @param reportsRequest $request
     * @return array
     */
    public function users(reportsRequest $request)
    {
        $peformances  = $this->caoFatura->usersPeformance($request->users,$request->start_date,$request->end_date);
        $avgFixedCost = $this->caoSalario->averageFixedCost($request->users);
        return response()->json([
            'avg_fixed_cost' => $avgFixedCost->avg_fixed_cost,
            'users'          => $peformances
        ],200);
    }
}


