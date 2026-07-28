<div class="space-y-6">
    <!-- Título & Subtítulo (Muda dinamicamente conforme a etapa) -->
    <div class="text-center relative">
        @if ($step > 1)
        <button wire:click="goBack" type="button" class="absolute left-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </button>
        @endif

        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
            Criar Conta do Lojista 🛒
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            @if($step == 1)
            Insira seu convite exclusivo para iniciar o cadastro.
            @elseif($step == 2)
            Informe seus dados para criar o usuário administrador.
            @else
            Crie uma senha segura para acessar seu painel.
            @endif
        </p>
    </div>

    <!-- ================= ETAPA 1: O CONVITE ================= -->
    @if ($step === 1)
    <div class="space-y-5">
        <div>
            <label for="invitation_code" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                Código de Convite
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"></path>
                    </svg>
                </div>
                <input id="invitation_code"
                    type="text"
                    wire:model="invitation_code"
                    placeholder="Ex: ABC-123-XYZ"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
            </div>
            @if ($invitationError)
            <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $invitationError }}</p>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button
                wire:click="validateInvitation"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="validateInvitation">Validar Convite</span>
                <span wire:loading wire:target="validateInvitation">Verificando...</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </x-primary-button>
        </div>
    </div>
    @endif

    <!-- ================= ETAPA 2: DADOS DO DONO ================= -->
    @if ($step === 2)
    <div class="space-y-5">
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                Seu Nome Completo
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input id="name"
                    type="text"
                    wire:model="name"
                    placeholder="Ex: João da Silva"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
            </div>
            @error('name') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                Endereço de E-mail
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email"
                    type="email"
                    wire:model="email"
                    placeholder="seu@email.com"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
            </div>
            @error('email') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="button"
                wire:click="proceedToPassword"
                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform active:scale-[0.99] transition-all duration-200">
                <span>Continuar para Senha</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- ================= ETAPA 3: SENHA ================= -->
    @if ($step === 3)
    <div class="space-y-5">
        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                Sua Senha
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password"
                    type="password"
                    wire:model="password"
                    placeholder="••••••••"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
            </div>
            @error('password') <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                Confirme a Senha
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <input id="password_confirmation"
                    type="password"
                    wire:model="password_confirmation"
                    placeholder="••••••••"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
            </div>
        </div>

        <div class="pt-2">
            <x-primary-button
                wire:click="register"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Finalizar Cadastro</span>
                <span wire:loading wire:target="register">Criando Conta...</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </x-primary-button>
        </div>
    </div>
    @endif

    <!-- Rodapé -->
    <div class="pt-4 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-500">
            Já possui uma conta registrada?
            <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors ms-1">
                Fazer Login
            </a>
        </p>
    </div>
</div>