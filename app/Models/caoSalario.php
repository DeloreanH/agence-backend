<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class caoSalario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cao_salario';


    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    /**
     * The primary keys associated with the table.
     *
     * @var array
     */
    protected $primaryKey = ['co_usuario', 'dt_alteracao'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'co_usuario',
        'dt_alteracao',
        'brut_salario',
        'liq_salario'
    ];

    /**
     * get average fixed cost of selected users
     * @param string[] $users
     * @return CaoFatura
     */
    public function averageFixedCost($users)
    {
        return $this->select(DB::raw('round(ifnull(avg(brut_salario),0),2) as avg_fixed_cost'))
            ->whereIn('co_usuario', $users)
            ->first();
    }
}
