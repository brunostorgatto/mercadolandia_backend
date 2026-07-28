<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Estabelecimento; // O model do seu estabelecimento
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class OwnerRegisterWizard extends Component
{
    public $step = 1; // Começa na etapa 1 (Convite)

    // Campos do Formulário
    public $invitation_code = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public $invitationError = '';

    // ==========================================
    // ETAPA 1: VALIDAR O CONVITE
    // ==========================================
    public function validateInvitation()
    {
        $this->invitationError = '';

        if (empty($this->invitation_code)) {
            $this->invitationError = 'Por favor, insira o código do convite.';
            return;
        }

        $invitation = Invitation::where('code', $this->invitation_code)->first();

        if (!$invitation) {
            $this->invitationError = 'Este código de convite não existe.';
            return;
        }

        if ($invitation->used_at) {
            $this->invitationError = 'Este convite já foi utilizado.';
            return;
        }

        if ($invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
            $this->invitationError = 'Este convite já expirou.';
            return;
        }

        // Se o convite tem um e-mail pré-definido, já preenche o campo
        if ($invitation->email) {
            $this->email = $invitation->email;
        }

        $this->step = 2; // Passou! Vai para a tela de Nome e Email
    }

    // ==========================================
    // ETAPA 2: VALIDAR DADOS DO USUÁRIO
    // ==========================================
    public function proceedToPassword()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
        ]);

        $this->step = 3; // Passou! Vai para a tela de Senha
    }

    // ==========================================
    // ETAPA 3: FINALIZAR E CADASTRAR
    // ==========================================
    public function register()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        // 1. Cria um estabelecimento inicial (o dono vai editar isso no painel depois)
        $estabelecimento = Estabelecimento::create([
            'nome' => 'Meu Mercado', // Nome padrão provisório
            // Outros campos obrigatórios da sua tabela de estabelecimentos podem ir aqui com valores em branco
        ]);

        // 2. Cria o Usuário vinculando ao Estabelecimento
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'estabelecimento_id' => $estabelecimento->id, // Vincula o ID conforme você explicou
            'nivel_acesso' => 'admin', // Substitua 'nivel_acesso' pelo nome exato da sua coluna
        ]);

        // 3. Queima o convite para não ser usado novamente
        Invitation::where('code', $this->invitation_code)->update(['used_at' => now()]);

        // 4. Faz o login automático
        Auth::login($user);

        // 5. Redireciona para o painel
        return redirect()->to('/dashboard'); // Mude para a rota do seu painel
    }

    // ==========================================
    // VOLTAR ETAPA
    // ==========================================
    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }


    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.owner-register-wizard');
    }
}
