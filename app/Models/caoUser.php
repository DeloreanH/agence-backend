<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class caoUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cao_usuario';

   /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


   /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'co_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'co_usuario',
        'no_usuario',
        'ds_senha',
        'co_usuario_autorizacao',
        'nu_matricula','
         dt_nascimento',
         'dt_admissao_empresa',
         'dt_desligamento',
         'dt_inclusao',
         'dt_expiracao',
         'nu_cpf',
         'nu_rg',
         'no_orgao_emissor',
         'uf_orgao_emissor',
         'ds_endereco',
         'no_email',
         'no_email_pessoal',
         'nu_telefone',
         'dt_alteracao',
         'url_foto',
         'instant_messenger',
         'icq',
         'msn',
         'yms',
         'ds_comp_end',
         'ds_bairro',
         'nu_cep',
         'no_cidade',
         'uf_cidade',
         'dt_expedicao'
    ];

   /**
     * get user permissions
     */
    public function permissaoSistema()
    {
        return $this->hasOne('App\Models\permissaoSistema','co_usuario','co_usuario');
    }

    /**
     * get consultans of agence
     * @return caoUser
     */
    public function consultans()
    {
      return $this->WhereHas('permissaoSistema', function ($query) {
             $query->where('co_sistema', '=', 1)
                   ->where('in_ativo', '=', 'S')
                   ->whereIn('co_tipo_usuario', [0,1,2]);
        })->select('co_usuario','no_usuario','dt_nascimento')->get();
    }

}
