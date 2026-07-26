<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                Verifique seu E-mail 📩
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Obrigado por se cadastrar! Antes de começar, por favor confirme seu endereço de e-mail clicando no link enviado para você.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs font-bold text-emerald-800">
                Um novo link de verificação foi enviado para o seu e-mail cadastrado.
            </div>
        @endif

        <div class="space-y-3 pt-2">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition-all">
                    <span>Reenviar E-mail de Verificação</span>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-xs font-bold text-slate-500 hover:text-slate-700 hover:underline transition">
                    Sair da Conta
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
