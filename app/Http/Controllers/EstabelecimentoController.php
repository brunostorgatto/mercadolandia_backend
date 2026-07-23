<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EstabelecimentoController extends Controller
{
    /**
     * Exibe o formulário de cadastro/edição do estabelecimento do lojista logado.
     */
    public function edit()
    {
        $user = auth()->user();
        $estabelecimento = $user->estabelecimento_id 
            ? Estabelecimento::find($user->estabelecimento_id) 
            : new Estabelecimento();

        return view('estabelecimento.form', compact('estabelecimento'));
    }

    /**
     * Salva ou atualiza os dados do estabelecimento.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $estabelecimentoId = $user->estabelecimento_id;

        $validated = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'razao_social'  => 'required|string|max:255',
            'cnpj'          => [
                'required',
                'string',
                'max:20',
                Rule::unique('estabelecimentos', 'cnpj')->ignore($estabelecimentoId),
            ],
            'telefone'      => 'required|string|max:20',
            'email_contato' => 'required|email|max:255',
            'cep'           => 'required|string|max:10',
            'logradouro'    => 'required|string|max:255',
            'numero'        => 'required|string|max:20',
            'complemento'   => 'nullable|string|max:255',
            'bairro'        => 'required|string|max:255',
            'cidade'        => 'required|string|max:255',
            'estado'        => 'required|string|size:2',
        ], [
            'nome_fantasia.required' => 'O nome fantasia é obrigatório.',
            'razao_social.required'  => 'A razão social é obrigatória.',
            'cnpj.required'          => 'O CNPJ é obrigatório.',
            'cnpj.unique'            => 'Este CNPJ já está cadastrado em outro estabelecimento.',
            'telefone.required'      => 'O telefone é obrigatório.',
            'email_contato.required' => 'O e-mail de contato é obrigatório.',
            'cep.required'           => 'O CEP é obrigatório.',
            'logradouro.required'    => 'O logradouro é obrigatório.',
            'numero.required'        => 'O número é obrigatório.',
            'bairro.required'        => 'O bairro é obrigatório.',
            'cidade.required'        => 'A cidade é obrigatória.',
            'estado.required'        => 'O estado (UF) é obrigatório.',
        ]);

        if ($estabelecimentoId) {
            $estabelecimento = Estabelecimento::findOrFail($estabelecimentoId);
            $estabelecimento->update($validated);
        } else {
            $estabelecimento = Estabelecimento::create($validated);
            $user->estabelecimento_id = $estabelecimento->id;
            $user->save();
        }

        return redirect()->route('estabelecimento.edit')->with('success', 'Dados do estabelecimento salvos com sucesso!');
    }
}
