<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importacao extends Model 
{

    protected $fillable = [
        'id', 'arquivo', 'totalLinhas', 'totalImportado', 'created_at', 'updated_at'
    ];

}
