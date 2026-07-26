<section class="space-y-6">
    <header class="pb-4 border-b border-rose-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-extrabold text-rose-600">
                Excluir Conta Permanentemente
            </h3>
            <p class="text-xs text-slate-500 mt-1">
                Esta ação é irreversível. Todos os dados associados à sua conta serão apagados.
            </p>
        </div>
        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
            ⚠️
        </div>
    </header>

    <div>
        <button type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="inline-flex items-center gap-2 px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-md shadow-rose-600/20 transition-all hover:scale-[1.01] active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Excluir Minha Conta
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 text-center space-y-5">
            @csrf
            @method('delete')

            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <div>
                <h3 class="text-lg font-extrabold text-slate-900">
                    Tem certeza que deseja excluir sua conta?
                </h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Após a exclusão, todos os recursos e dados do seu usuário serão excluídos permanentemente. Digite sua senha para confirmar a exclusão da conta.
                </p>
            </div>

            <div class="text-left">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Digite Sua Senha para Confirmar
                </label>
                <input id="password"
                       name="password"
                       type="password"
                       placeholder="••••••••"
                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 transition" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5 text-xs text-rose-500 font-medium" />
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 py-3 px-4 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/30 transition">
                    Sim, Excluir Minha Conta
                </button>
            </div>
        </form>
    </x-modal>
</section>
