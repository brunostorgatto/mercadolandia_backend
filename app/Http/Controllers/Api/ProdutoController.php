<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Retorna apenas os produtos do mercado informado
     */
    public function index(Request $request, $estabelecimento)
    {
        // Filtra os produtos onde a categoria pertence ao mercado (estabelecimento)
        $produtos = Produto::whereHas('categoria', function ($query) use ($estabelecimento) {
            $query->where('estabelecimento_id', $estabelecimento);
        })
        ->orderBy('nome')
        ->get();

        return response()->json([
            'success' => true,
            'data'    => $produtos
        ], 200);
    }
}