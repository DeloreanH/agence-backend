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
        if(Empty($peformances)){
            return response()->json([],200);
        } else {
            $peformancesWithTotals = $this->calculateTotals($peformances);
            $avgFixedCost          = $this->caoSalario->averageFixedCost($request->users);
            return response()->json([
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'avg_fixed_cost' => $avgFixedCost->avg_fixed_cost,
                'users'          => array_values($peformancesWithTotals)
            ],200);
        }
    }

    /**
     * calculate total performances per user
     * @param array $peformances
     * @return array
     */
    private function calculateTotals(array $peformances) {
        foreach ($peformances as $user => $peformance) {
            $peformances[$user]['total_fixed_cost'] = round($this->sumTotal($peformance,'fixed_cost'),2);
            $peformances[$user]['total_net_income'] = round($this->sumTotal($peformance,'net_income'),2);
            $peformances[$user]['total_commission'] = round($this->sumTotal($peformance,'commission'),2);
            $peformances[$user]['total_profit']     = round($this->sumTotal($peformance,'profit'),2);
        }
        return $peformances;
    }

   /**
     * sum the totals of the specified field
     * @param array $userPeformance
     * @return array
     */
    private function sumTotal(array $userPeformance, string $fieldToSum){
       return array_reduce($userPeformance['data'], function($accu, $current) use ($fieldToSum) {
            return $accu = $accu +  $current[$fieldToSum];
        },$initial=0);
    }

}