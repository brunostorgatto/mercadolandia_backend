<nav x-data="{ open: false, confirmLogout: false }" class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-slate-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-semibold">
                        {{ __('Painel Inicial') }}
                    </x-nav-link>
                    <x-nav-link :href="route('estabelecimento.edit')" :active="request()->routeIs('estabelecimento.*')" class="text-sm font-semibold">
                        {{ __('Meu Estabelecimento') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*') || request()->routeIs('produtos.*')" class="text-sm font-semibold">
                        {{ __('Produtos') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: Store Badge & User Menu -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">

                <!-- Badge do Nome Fantasia da Loja -->
                @if (Auth::user()->estabelecimento_id && Auth::user()->estabelecimento)
                    <a href="{{ route('estabelecimento.edit') }}" title="Gerenciar Estabelecimento" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold hover:bg-emerald-100 transition shadow-sm">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 012-2v-5a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 012 2m-6 0h6"></path>
                        </svg>
                        <span class="max-w-[180px] truncate font-extrabold">{{ Auth::user()->estabelecimento->nome_fantasia }}</span>
                    </a>
                @else
                    <a href="{{ route('estabelecimento.edit') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold hover:bg-amber-100 transition animate-pulse">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Cadastrar Estabelecimento</span>
                    </a>
                @endif

                <!-- User Profile Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 text-sm font-semibold rounded-xl text-slate-700 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 focus:outline-none transition duration-150">
                            <!-- Avatar Circle -->
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-bold leading-tight text-slate-800">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-500 capitalize leading-none mt-0.5">
                                    {{ Auth::user()->role ?? 'Lojista' }}
                                </span>
                            </div>

                            <svg class="h-4 w-4 text-slate-400 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Store Legal Info & User Header -->
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 space-y-1.5">
                            @if (Auth::user()->estabelecimento_id && Auth::user()->estabelecimento)
                                <div>
                                    <p class="text-[10px] uppercase font-bold tracking-wider text-emerald-600">Nome Fantasia</p>
                                    <p class="text-xs font-extrabold text-slate-800 truncate">
                                        {{ Auth::user()->estabelecimento->nome_fantasia }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Razão Social</p>
                                    <p class="text-[11px] font-semibold text-slate-700 truncate">
                                        {{ Auth::user()->estabelecimento->razao_social }}
                                    </p>
                                    <p class="text-[10px] text-slate-500 font-mono">
                                        CNPJ: {{ Auth::user()->estabelecimento->cnpj }}
                                    </p>
                                </div>
                            @else
                                <p class="text-xs font-bold text-amber-700">Nenhum estabelecimento cadastrado</p>
                            @endif

                            <div class="pt-1.5 border-t border-slate-200/60">
                                <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Usuário Logado</p>
                                <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <!-- Dropdown Links -->
                        <x-dropdown-link :href="route('estabelecimento.edit')" class="flex items-center gap-2 text-xs font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 012-2v-5a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 012 2m-6 0h6"></path>
                            </svg>
                            <span>Configurar Estabelecimento</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-xs font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Meu Perfil</span>
                        </x-dropdown-link>


                        <div class="border-t border-slate-100"></div>

                        <!-- Button Trigger Logout Modal -->
                        <button type="button" 
                                @click="confirmLogout = true"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center gap-2 transition">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Sair da Conta</span>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50 border-b border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Painel Inicial') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('estabelecimento.edit')" :active="request()->routeIs('estabelecimento.*')">
                {{ __('Meu Estabelecimento') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*') || request()->routeIs('produtos.*')">
                {{ __('Produtos') }}
            </x-responsive-nav-link>
        </div>

        <!-- Store & User Info Mobile -->
        <div class="pt-4 pb-3 border-t border-slate-200 px-4 space-y-3">
            <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm space-y-1">
                @if (Auth::user()->estabelecimento_id && Auth::user()->estabelecimento)
                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Nome Fantasia</p>
                    <p class="text-sm font-extrabold text-slate-800">
                        {{ Auth::user()->estabelecimento->nome_fantasia }}
                    </p>
                    <p class="text-[11px] text-slate-600 truncate">
                        Razão Social: {{ Auth::user()->estabelecimento->razao_social }}
                    </p>
                @else
                    <p class="text-xs font-bold text-amber-700">Nenhum estabelecimento cadastrado</p>
                @endif
                <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="capitalize text-[10px] bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-slate-700">{{ Auth::user()->role ?? 'Lojista' }}</span>
                </div>
            </div>


            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Meu Perfil') }}
                </x-responsive-nav-link>

                <button type="button" 
                        @click="open = false; confirmLogout = true" 
                        class="w-full text-left block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-rose-600 hover:text-rose-800 hover:bg-rose-50 hover:border-rose-300 transition duration-150 ease-in-out">
                    {{ __('Sair da Conta') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form x-ref="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    <!-- Logout Confirmation Modal (Alpine.js) -->
    <div x-show="confirmLogout" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm"
         style="display: none;">
        
        <div @click.away="confirmLogout = false" 
             class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform transition-all space-y-5">
            
            <!-- Warning Icon -->
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>

            <div>
                <h3 class="text-lg font-extrabold text-slate-900">
                    Confirmar Saída 🚪
                </h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Você realmente deseja encerrar sua sessão no painel do <strong class="text-slate-700">Mercadolandia</strong>?
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" 
                        @click="confirmLogout = false" 
                        class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Cancelar
                </button>
                <button type="button" 
                        @click="$refs.logoutForm.submit()" 
                        class="flex-1 py-3 px-4 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/30 transition">
                    Sim, Sair
                </button>
            </div>
        </div>
    </div>
</nav>

