<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissaoSistema extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissao_sistema';


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
    protected $primaryKey = ['co_usuario', 'co_tipo_usuario','co_sistema'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'co_usuario',
        'co_tipo_usuario',
        'co_sistema',
        'in_ativo',
        'co_usuario_atualizacao',
        'dt_atualizacao'
    ];

   /**
     * get user
     */
    public function caoUser()
    {
        return $this->belongsTo('App\Models\caoUser', 'co_usuario');

    }

}
