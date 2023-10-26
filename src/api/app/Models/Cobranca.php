<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model 
{

    protected $fillable = [
        'name','governmentId','email', 'debtAmount', 'debtDueDate', 'debtId', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'id';
}
