<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;

// ✅ Rota ajustada para receber o ID do mercado (estabelecimento)
Route::get('/v1/estabelecimentos/{estabelecimento}/produtos', [ProdutoController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');