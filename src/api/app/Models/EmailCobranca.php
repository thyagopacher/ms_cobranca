<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailCobranca extends Model 
{

    protected $table = "mail_cobrancas"; 

    protected $fillable = [
        'idCobranca', 'assunto', 'corpo', 'dataEnvio','created_at', 'updated_at'
    ];

    protected $primaryKey = 'id';

    public function scopeListEmails($query, array $params){
   
        if(!empty($params['id'])){
            $query->where('id', $params['id']);
        }

        if(!empty($params['naoEnviados'])){
            $query->whereNull('dataEnvio');
        }    
           
        if(!empty($params['limite'])){
            $query->limit($params['limite']);
        }
        return $query->selectRaw('*')->get();
    }
}
