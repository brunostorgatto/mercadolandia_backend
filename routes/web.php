<?php 
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstabelecimentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $totalCategorias = \App\Models\Categoria::where('user_id', $user->id)->count();
        $totalProdutos = \App\Models\Produto::whereHas('categoria', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        return view('dashboard', compact('totalCategorias', 'totalProdutos'));
    })->name('dashboard');

    // Rotas do Estabelecimento
    Route::get('/estabelecimento', [EstabelecimentoController::class, 'edit'])->name('estabelecimento.edit');
    Route::post('/estabelecimento', [EstabelecimentoController::class, 'store'])->name('estabelecimento.store');

    // Rotas de Categorias
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::post('/categorias/reorder', [CategoriaController::class, 'reorder'])->name('categorias.reorder');

    // Rotas de Produtos
    Route::get('/categorias/{categoria}/produtos', [ProdutoController::class, 'index'])->name('categorias.produtos');
    Route::post('/categorias/{categoria}/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';