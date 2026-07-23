<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['categoria_id', 'nome', 'preco', 'unidade_medida', 'incremento', 'imagem'];

    protected $casts = [
        'preco'      => 'decimal:2',
        'incremento' => 'decimal:3',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->imagem && file_exists(storage_path('app/public/' . $this->imagem))) {
            return asset('storage/' . $this->imagem);
        }
        return '';
    }
}
