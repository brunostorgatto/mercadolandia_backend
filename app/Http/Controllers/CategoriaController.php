<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    /** Lista todas as categorias do estabelecimento do usuário logado */
    public function index()
    {
        $estabelecimentoId = Auth::user()->estabelecimento_id;

        $categorias = Categoria::where('estabelecimento_id', $estabelecimentoId)
            ->withCount('produtos')
            ->orderBy('ordem')
            ->orderBy('created_at')
            ->get();

        return view('categorias.index', compact('categorias'));
    }

    /** Cria nova categoria para o estabelecimento */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        $estabelecimentoId = Auth::user()->estabelecimento_id;

        $maxOrdem = Categoria::where('estabelecimento_id', $estabelecimentoId)->max('ordem') ?? 0;

        Categoria::create([
            'estabelecimento_id' => $estabelecimentoId,
            'nome'               => $request->nome,
            'ordem'              => $maxOrdem + 1,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /** Atualiza nome da categoria */
    public function update(Request $request, Categoria $categoria)
    {
        $this->authorizeCategoria($categoria);

        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        $categoria->update(['nome' => $request->nome]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'nome' => $categoria->nome]);
        }

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada!');
    }

    /** Remove a categoria (apenas se não tiver produtos) */
    public function destroy(Categoria $categoria)
    {
        $this->authorizeCategoria($categoria);

        if ($categoria->produtos()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Remova os produtos desta categoria antes de excluí-la.'], 422);
            }
            return back()->with('error', 'Remova os produtos desta categoria antes de excluí-la.');
        }

        $categoria->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria removida!');
    }

    /** Salva nova ordem das categorias (chamada via AJAX) */
    public function reorder(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids && $request->isJson()) {
            $ids = $request->json('ids');
        }

        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs de categorias não fornecidos.'], 422);
        }

        $estabelecimentoId = Auth::user()->estabelecimento_id;

        foreach ($ids as $ordem => $id) {
            Categoria::where('id', (int) $id)
                ->where('estabelecimento_id', $estabelecimentoId)
                ->update(['ordem' => $ordem + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function authorizeCategoria(Categoria $categoria): void
    {
        abort_if($categoria->estabelecimento_id !== Auth::user()->estabelecimento_id, 403);
    }
}