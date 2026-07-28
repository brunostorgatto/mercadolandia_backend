<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class OwnerRegisterWizard extends Component
{
    public $step = 1;

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
            $this->invitationError = __('messages.invite.required');
            return;
        }

        $this->invitation_code = strtoupper(trim($this->invitation_code));

        if (!preg_match('/^[A-Z]{2}[0-9]{4}$/', $this->invitation_code)) {
            $this->invitationError = __('messages.invite.invalid_format');
            return;
        }

        $invitation = Invitation::where('code', $this->invitation_code)->first();

        if (!$invitation) {
            $this->invitationError = __('messages.invite.not_found');
            return;
        }

        if ($invitation->used_at) {
            $this->invitationError = __('messages.invite.used');
            return;
        }

        if ($invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
            $this->invitationError = __('messages.invite.expired');
            return;
        }

        if ($invitation->email) {
            $this->email = $invitation->email;
        }

        $this->step = 2;
    }

    // ==========================================
    // ETAPA 2: VALIDAR DADOS DO USUÁRIO
    // ==========================================
    public function proceedToPassword()
    {
        $this->validate([
            'name'  => 'required|min:3',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required'  => __('messages.user.name_required'),
            'name.min'       => __('messages.user.name_min'),
            'email.required' => __('messages.user.email_required'),
            'email.email'    => __('messages.user.email_invalid'),
            'email.unique'   => __('messages.user.email_unique'),
        ]);

        $this->step = 3;
    }

    // ==========================================
    // ETAPA 3: FINALIZAR E CADASTRAR
    // ==========================================
    public function register()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required'  => __('messages.password.required'),
            'password.min'       => __('messages.password.min'),
            'password.confirmed' => __('messages.password.confirmed'),
        ]);


        // 1. Cria o estabelecimento base com dados temporários
        $estabelecimento = Estabelecimento::create([
            'nome_fantasia' => 'Meu Mercado',
            'razao_social'  => 'Razão Social Padrão',
            'cnpj'          => '00.000.000/0000-00',
            'telefone'      => '(00) 00000-0000',
            'email_contato' => $this->email,
            'cep'           => '00000-000',
            'logradouro'    => 'Endereço Padrão',
            'numero'        => 'S/N',
            'complemento'   => null, // Esse é o único que aceita Null no seu banco
            'bairro'        => 'Bairro Padrão',
            'cidade'        => 'Cidade Padrão',
            'estado'        => 'XX',
        ]);

        // 2. Cria o Usuário vinculando ao Estabelecimento
        $user = User::create([
            'name'               => $this->name,
            'email'              => $this->email,
            'password'           => Hash::make($this->password),
            'estabelecimento_id' => $estabelecimento->id,
            'role'       => 'admin',
        ]);

        // 3. Queima o convite para não ser usado novamente
        Invitation::where('code', $this->invitation_code)->update(['used_at' => now()]);

        // 4. Faz o login automático
        Auth::login($user);

        // 5. Redireciona para o painel principal
        return redirect()->to('/dashboard');
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
