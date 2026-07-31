<x-guest-layout>
    <div class="space-y-6">
        <!-- Title & Subtitle -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                Recuperar Senha 🔑
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Esqueceu sua senha? Sem problemas! Informe seu e-mail para enviarmos o link de redefinição.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm font-medium text-emerald-600 bg-emerald-50 p-3 rounded-xl border border-emerald-200" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
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
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="seu@email.com"
                        class="block w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full"> <span>Enviar Link de Redefinição</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </x-primary-button>
            </div>
        </form>

        <!-- Footer Link -->
        <div class="pt-4 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Lembrou da senha?
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors ms-1">
                    Voltar para o Login
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>