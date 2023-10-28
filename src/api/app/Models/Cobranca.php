<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cobranca extends Model 
{

    protected $table = "cobrancas"; 

    protected $fillable = [
        'name', 
        'governmentId', //número do documento
        'email', //email do sacado
        'debtAmount', //valor
        'debtDueDate', //Data para ser paga 
        'debtId', //uuid para o débito
        'created_at', 
        'updated_at'
    ];

    protected $primaryKey = 'id';

    public function scopeListCobranca($query, array $params){
        if(!empty($params['diaParaEnvioCobranca'])){
            $hoje = date('Y-m-d');
            $query->where('debtDueDate', '<=', $hoje);
        }            
        if(!empty($params['enviadoCobranca'])){
            if($params['enviadoCobranca'] == "S"){
                $query->whereRaw('id in(select idCobranca from mail_cobrancas)');
            }elseif($params['enviadoCobranca'] == "N"){
                $query->whereRaw('id not in(select idCobranca from mail_cobrancas)');
            }
        }       
        
        if(!empty($params['id'])){
            $query->where('id', $params['id']);
        }     
        if(!empty($params['pagina'])){
            $limite = $params['limite'];
            $pagina = $params['pagina'];
            $query->skip(($pagina - 1) * $limite); // Pula registros
            $query->take($limite); // Limita a quantidade de registros
        }elseif(!empty($params['limite'])){
            $query->limit($params['limite']);
        }        

        $query->orderBy('id', 'asc');

        return $query->selectRaw('*')->get();
    }
}
