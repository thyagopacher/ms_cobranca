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


}
