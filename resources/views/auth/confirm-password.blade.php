<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                Confirmação de Segurança 🔐
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Esta é uma área protegida. Por favor, confirme sua senha antes de continuar.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                    Sua Senha
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="block w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500" />
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition-all">
                    <span>Confirmar Senha</span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
