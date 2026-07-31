@props(['textoClaro' => false])

<div class="flex items-center gap-3 select-none">
    {{-- Ícone do Carrinho (Corrigido para 500 e 600, que existem no seu config) --}}
    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 shadow-lg shadow-brand-500/40 text-white shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
    </div>

    {{-- Textos --}}
    <div class="flex flex-col justify-center">
        <div class="text-3xl font-black tracking-tight flex items-baseline leading-none">
            {{-- "Mercado" usa o 600 para dar contraste bom no branco --}}
            <span class="text-brand-600">Mercado</span>
            
            {{-- "landia" é condicional! Olha a mágica: --}}
            <span class="{{ $textoClaro ? 'text-slate-100' : 'text-slate-800' }}">landia</span>
        </div>
        
        <span class="text-[10px] font-extrabold tracking-[0.2em] text-brand-600/90 uppercase mt-1">
            Painel Administrativo
        </span>
    </div>
</div>