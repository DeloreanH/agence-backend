<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class caoFatura extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cao_fatura';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'co_fatura';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'co_fatura',
        'co_cliente',
        'co_sistema',
        'co_os',
        'num_nf',
        'total',
        'valor',
        'data_emissao',
        'corpo_nf',
        'comissao_cn',
        'total_imp_inc'
    ];

    /**
     * get users peformance by month in a date range
     * @param string[] $users
     * @param string $start
     * @param string $end
     * @return array
     */
    public function usersPeformance($users, $start, $end)
    {   $select = 'cao_usuario.co_usuario as user_id,
                   cao_usuario.no_usuario as user_name,
                   date_format(cao_fatura.data_emissao,"%Y-%m") AS date_period,
                   ifnull(cao_salario.brut_salario,0) as fixed_cost, 
                   round(sum((cao_fatura.valor - ((cao_fatura.valor * cao_fatura.total_imp_inc) / 100))),2) as net_income,
                   round(sum((((cao_fatura.valor - ((cao_fatura.valor * cao_fatura.total_imp_inc) / 100)) * cao_fatura.comissao_cn) / 100 )),2) as commission';

        return $this->select(DB::raw($select))
             ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
             ->join('cao_usuario', 'cao_os.co_usuario', '=', 'cao_usuario.co_usuario')
             ->leftJoin('cao_salario', 'cao_usuario.co_usuario', '=', 'cao_salario.co_usuario')
             ->whereBetween(DB::raw('date_format(cao_fatura.data_emissao,"%Y-%m")'), [$start, $end])
             ->whereIn('cao_usuario.co_usuario', $users)
             ->groupBy('user_id','user_name', 'date_period', 'fixed_cost')
             ->orderBy('date_period', 'ASC')
             ->orderBy('user_name', 'ASC')
             ->get()
             ->reduce(function ($carry, $item) {
                 $carry[$item['user_id']]['name'] = $item->user_name;
                 $carry[$item['user_id']]['data'][] = [
                     "date_period" => $item->date_period,
                     "fixed_cost"  => $item->fixed_cost,
                     "net_income"  => $item->net_income,
                     "commission"  => $item->commission,
                     "profit"      => round($item->net_income - ($item->fixed_cost + $item->commission),2),
                 ];
                return $carry;
            });
    }
}
