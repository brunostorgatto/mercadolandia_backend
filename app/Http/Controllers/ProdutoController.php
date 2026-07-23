<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    /** Exibe os produtos de uma categoria */
    public function index(Categoria $categoria)
    {
        abort_if($categoria->user_id !== Auth::id(), 403);

        $produtos = $categoria->produtos()->orderBy('nome')->get();

        return view('categorias.produtos', compact('categoria', 'produtos'));
    }

    /** Cria novo produto (recebe imagem como base64 do cropper) */
    public function store(Request $request, Categoria $categoria)
    {
        abort_if($categoria->user_id !== Auth::id(), 403);

        $request->validate([
            'nome'          => 'required|string|max:150',
            'preco'         => 'required|numeric|min:0',
            'unidade_medida'=> 'required|in:un,kg,g,l',
            'incremento'    => 'required|numeric|min:0.001',
            'imagem_base64' => 'nullable|string',
        ]);

        $imagemPath = null;

        if ($request->filled('imagem_base64')) {
            $imagemPath = $this->salvarImagemBase64($request->imagem_base64);
        }

        Produto::create([
            'categoria_id'   => $categoria->id,
            'nome'           => $request->nome,
            'preco'          => $request->preco,
            'unidade_medida' => $request->unidade_medida,
            'incremento'     => $request->incremento,
            'imagem'         => $imagemPath,
        ]);

        return redirect()->route('categorias.produtos', $categoria)
            ->with('success', 'Produto adicionado com sucesso!');
    }

    /** Exibe formulário de edição */
    public function edit(Produto $produto)
    {
        $categoria = $produto->categoria;
        abort_if($categoria->user_id !== Auth::id(), 403);

        return view('categorias.produto-form', compact('produto', 'categoria'));
    }

    /** Atualiza produto */
    public function update(Request $request, Produto $produto)
    {
        $categoria = $produto->categoria;
        abort_if($categoria->user_id !== Auth::id(), 403);

        $request->validate([
            'nome'          => 'required|string|max:150',
            'preco'         => 'required|numeric|min:0',
            'unidade_medida'=> 'required|in:un,kg,g,l',
            'incremento'    => 'required|numeric|min:0.001',
            'imagem_base64' => 'nullable|string',
        ]);

        $dados = [
            'nome'           => $request->nome,
            'preco'          => $request->preco,
            'unidade_medida' => $request->unidade_medida,
            'incremento'     => $request->incremento,
        ];

        if ($request->filled('imagem_base64')) {
            // Remove imagem antiga
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $dados['imagem'] = $this->salvarImagemBase64($request->imagem_base64);
        }

        $produto->update($dados);

        return redirect()->route('categorias.produtos', $categoria)
            ->with('success', 'Produto atualizado!');
    }

    /** Remove produto e sua imagem */
    public function destroy(Produto $produto)
    {
        $categoria = $produto->categoria;
        abort_if($categoria->user_id !== Auth::id(), 403);

        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->route('categorias.produtos', $categoria)
            ->with('success', 'Produto removido!');
    }

    /** Salva imagem base64 no storage e retorna o path relativo */
    private function salvarImagemBase64(string $base64): string
    {
        // Remove o prefixo data:image/...;base64,
        $dados = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
        $dados = str_replace(' ', '+', $dados);
        $binario = base64_decode($dados);

        $nomeArquivo = 'produtos/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($nomeArquivo, $binario);

        return $nomeArquivo;
    }
}
