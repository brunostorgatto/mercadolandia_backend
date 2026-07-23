<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Painel do Lojista 🛒
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero / Welcome Banner -->
            <div class="relative bg-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-2xl overflow-hidden border border-slate-800">
                <!-- Subtle Gradient Overlays -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3.5 py-1.5 rounded-full border border-emerald-500/30 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Mercadolandia Multi-Lojas
                    </div>

                    <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                        Olá, {{ Auth::user()->name }}! 👋
                    </h3>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        Bem-vindo ao seu painel. Gerencie seus produtos, organize seu catálogo e mantenha os dados do seu estabelecimento sempre atualizados.
                    </p>

                    <div class="pt-2 flex flex-wrap gap-3">
                        <a href="{{ route('categorias.index') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-emerald-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Gerenciar Produtos
                        </a>

                        <a href="{{ route('estabelecimento.edit') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-200 font-extrabold text-xs uppercase tracking-wider rounded-xl border border-slate-700 hover:scale-[1.02] active:scale-95 transition-all">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Meu Estabelecimento
                        </a>
                    </div>
                </div>

                <div class="absolute -right-8 -bottom-8 opacity-15 pointer-events-none hidden lg:block">
                    <svg class="w-80 h-80 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 012-2v-5a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 012 2m-6 0h6"></path>
                    </svg>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card 1: Status do Estabelecimento -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-7 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">
                                Estabelecimento
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center border border-teal-100 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 012-2v-5a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 012 2m-6 0h6"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-5 space-y-3">
                            @if(Auth::user()->estabelecimento_id && Auth::user()->estabelecimento)
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Loja Cadastrada
                                </div>
                                
                                <div>
                                    <h4 class="text-xl font-extrabold text-slate-900">
                                        {{ Auth::user()->estabelecimento->nome_fantasia }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ Auth::user()->estabelecimento->razao_social }}
                                    </p>
                                    @if(Auth::user()->estabelecimento->cnpj)
                                        <p class="text-[11px] font-mono text-slate-400 mt-1">
                                            CNPJ: {{ Auth::user()->estabelecimento->cnpj }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Pendente de Cadastro
                                </div>

                                <div>
                                    <h4 class="text-lg font-bold text-slate-800">
                                        Nenhum estabelecimento vinculado
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Cadastre os dados da sua loja para liberar todos os recursos do catálogo.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('estabelecimento.edit') }}" 
                           class="inline-flex items-center justify-between w-full text-xs font-bold text-slate-700 hover:text-emerald-600 group transition">
                            <span>Configurar Estabelecimento</span>
                            <span class="p-1.5 rounded-lg bg-slate-100 group-hover:bg-emerald-50 text-slate-500 group-hover:text-emerald-600 transition">
                                →
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Catálogo de Produtos -->
                <a href="{{ route('categorias.index') }}" 
                   class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-7 hover:shadow-md hover:border-emerald-300/80 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">
                                Catálogo Geral
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-xs group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div>
                                <h4 class="text-xl font-extrabold text-slate-900 group-hover:text-emerald-600 transition">
                                    Produtos & Categorias
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">
                                    Gerencie todas as categorias e produtos do seu cardápio em um só lugar.
                                </p>
                            </div>

                            <!-- Metrics Pills -->
                            <div class="grid grid-cols-2 gap-3 pt-1">
                                <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Produtos</span>
                                    <p class="text-2xl font-black text-slate-800 mt-0.5">
                                        {{ $totalProdutos }}
                                    </p>
                                </div>
                                <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Categorias</span>
                                    <p class="text-2xl font-black text-slate-800 mt-0.5">
                                        {{ $totalCategorias }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-600">
                        <span>Acessar Produtos →</span>
                        <span class="px-3 py-1 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-700 group-hover:bg-emerald-500 group-hover:text-white transition">
                            Abrir Catálogo
                        </span>
                    </div>
                </a>

            </div>

            <!-- Quick Access / Info Tiles -->
            <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200/60 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-extrabold text-slate-900">
                            Como organizar seu catálogo?
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Dicas rápidas para otimizar a experiência dos seus clientes.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div class="bg-white rounded-2xl p-4 border border-slate-200/70 shadow-2xs space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                            1
                        </div>
                        <h5 class="text-xs font-bold text-slate-800">Crie Categorias</h5>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Agrupe seus produtos por tipo (ex: Bebidas, Lanches, Sobremesas) e reordene arrastando.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-slate-200/70 shadow-2xs space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-xs">
                            2
                        </div>
                        <h5 class="text-xs font-bold text-slate-800">Cadastre Produtos</h5>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Adicione preços, escolha unidades de medida (un, kg, g, l) e foto dos itens.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-slate-200/70 shadow-2xs space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                            3
                        </div>
                        <h5 class="text-xs font-bold text-slate-800">Mantenha Atualizado</h5>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Altere valores e edite produtos com apenas alguns cliques no seu painel.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

