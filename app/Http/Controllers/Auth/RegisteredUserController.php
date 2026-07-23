<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Estabelecimento;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $estabelecimento = Estabelecimento::create([
            'nome_fantasia' => $request->name,
            'razao_social'  => 'A PREENCHER',
            'cnpj'          => '00.000.000/0000-00',
            'telefone'      => '0000000000',
            'email_contato' => 'email@provisorio.com',
            'cep'           => '00000000',
            'logradouro'    => 'A PREENCHER',
            'numero'        => '0',
            'bairro'        => 'A PREENCHER',
            'cidade'        => 'A PREENCHER',
            'estado'        => 'RS',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Força o primeiro usuário a ser admin
            'estabelecimento_id' => $estabelecimento->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
