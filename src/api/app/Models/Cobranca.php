<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model 
{

    protected $fillable = [
        'id', 'name','governmentId','email', 'debtAmount', 'debtDueDate', 'debtId', 'created_at', 'updated_at'
    ];

}
