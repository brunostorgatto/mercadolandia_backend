<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">👤 Meu Perfil</h1>
                <p class="text-sm text-slate-500 mt-0.5">Gerencie suas informações pessoais, e-mail e segurança de acesso.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Card 1: Informações do Perfil -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Card 2: Alterar Senha -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Card 3: Excluir Conta -->
            <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
