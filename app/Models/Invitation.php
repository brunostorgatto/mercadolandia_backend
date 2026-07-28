<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    // Liberando os campos para podermos inserir os convites no banco
    protected $fillable = [
        'code',
        'email',
        'expires_at',
        'used_at',
    ];
}