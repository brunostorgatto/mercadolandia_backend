<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => __('messages.user.email_required'),
            'email.email'       => __('messages.user.email_invalid'),
            'password.required' => __('messages.password.required'),
        ]);

        // Tenta realizar o login usando as credenciais
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('auth.failed'));
            return;
        }

        // Regenera a sessão por segurança
        session()->regenerate();

        // Redireciona para o painel
        return redirect()->intended('/dashboard');
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.login');
    }
}