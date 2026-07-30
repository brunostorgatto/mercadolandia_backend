<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['estabelecimento_id', 'nome', 'ordem'];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class)->orderBy('nome');
    }
}
