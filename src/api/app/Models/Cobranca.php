<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cobranca extends Model 
{

    protected $table = "cobrancas"; 

    protected $fillable = [
        'name','governmentId','email', 'debtAmount', 'debtDueDate', 'debtId', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'id';

    public function scopeListCobranca($query, array $params){
   
        if(!empty($params['id'])){
            $query->where('id', $params['id']);
        }       
        if(!empty($params['limite'])){
            $query->limit($params['limite']);
        }
        return $query->selectRaw('*')->get();
    }
}
