<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'categoria_id', 
        'nome', 
        'preco', 
        'unidade_medida', 
        'incremento', 
        'imagem'
    ];

    protected $casts = [
        'preco'      => 'decimal:2',
        'incremento' => 'decimal:3',
    ];

    // ✅ ADICIONE ESTA LINHA: Inclui o campo 'foto_url' no JSON automaticamente
    protected $appends = ['foto_url'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Accessor para a URL da imagem
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->imagem && file_exists(storage_path('app/public/' . $this->imagem))) {
            return asset('storage/' . $this->imagem);
        }

        return null;
    }
}