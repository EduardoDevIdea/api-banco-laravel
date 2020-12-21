<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_last_name',
        'cpf',
        'num_conta',
        'saldo',
    ];
}
