<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importacao extends Model 
{

    protected $fillable = [
        'arquivo', 'totalLinhas', 'totalImportado', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'id';

    public function scopeListFile($query, array $params){
        if(!empty($params['notFinished'])){
            $query->whereRaw('totalImportado < totalLinhas');
        }        
        if(!empty($params['id'])){
            $query->where('id', $params['id']);
        }
        return $query->selectRaw('*')->get();
    }
}
