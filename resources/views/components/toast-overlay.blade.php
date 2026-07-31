@if (session('success') || session('error') || session('warning') || session('info'))
@php
    $tipo = 'success';
    $titulo = 'Sucesso!';
    $corBgIcone = 'bg-brand-50 text-brand-600';
    $mensagem = session('success');

    if (session('error')) {
        $tipo = 'error';
        $titulo = 'Ops! Algo deu errado';
        $corBgIcone = 'bg-rose-50 text-rose-600';
        $mensagem = session('error');
    } elseif (session('warning')) {
        $tipo = 'warning';
        $titulo = 'Atenção!';
        $corBgIcone = 'bg-amber-50 text-amber-600';
        $mensagem = session('warning');
    } elseif (session('info')) {
        $tipo = 'info';
        $titulo = 'Informação';
        $corBgIcone = 'bg-sky-50 text-sky-600';
        $mensagem = session('info');
    }
@endphp

<div id="toast-overlay-global" 
     class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 transition-all duration-300 opacity-100">
    
    <div class="bg-white rounded-3xl max-w-sm w-full p-8 text-center shadow-2xl border border-slate-100 transform scale-100 transition-all duration-200">
        
        {{-- Ícone com fundo temático --}}
        <div class="w-16 h-16 rounded-2xl {{ $corBgIcone }} flex items-center justify-center mx-auto mb-4 shadow-sm">
            @if($tipo === 'success')
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            @elseif($tipo === 'error')
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            @elseif($tipo === 'warning')
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @else
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>

        {{-- Título e Mensagem --}}
        <h3 class="text-xl font-black text-slate-900 mb-1.5">
            {{ $titulo }}
        </h3>
        <p class="text-sm font-medium text-slate-600 leading-relaxed">
            {{ $mensagem }}
        </p>

        {{-- Barra de progresso discreta do timer --}}
        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mt-6">
            <div id="toast-overlay-bar" class="bg-brand-600 h-full w-full transition-all ease-linear" style="transition-duration: 2500ms;"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('toast-overlay-global');
        const bar = document.getElementById('toast-overlay-bar');
        
        if (overlay) {
            // Inicia animação da barra de progresso
            setTimeout(() => {
                if (bar) bar.style.width = '0%';
            }, 50);

            // Suaviza e remove da tela após 2.5 segundos (2500ms)
            setTimeout(() => {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.remove(), 300);
            }, 2500);
        }
    });
</script>
@endif