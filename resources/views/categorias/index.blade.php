<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">🗂️ Categorias e produtos</h1>
                <p class="text-sm text-slate-500 mt-0.5">Arraste para reordenar. Clique em uma categoria para gerenciar os produtos.</p>
            </div>
        </div>
    </x-slot>

    {{-- Notificações --}}
    @if (session('success'))
        <div id="toast-success"exit
             class="fixed top-20 right-5 z-50 flex items-center gap-3 bg-white border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3.5 rounded-2xl shadow-xl shadow-emerald-600/10 transition-all duration-500">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) t.style.opacity = '0'; }, 3500);</script>
    @endif

    @if (session('error'))
        <div id="toast-error"
             class="fixed top-20 right-5 z-50 flex items-center gap-3 bg-white border border-rose-200 text-rose-800 text-sm font-semibold px-5 py-3.5 rounded-2xl shadow-xl shadow-rose-600/10 transition-all duration-500">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-error'); if(t) t.style.opacity = '0'; }, 4000);</script>
    @endif

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Card de criação --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <form method="POST" action="{{ route('categorias.store') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                            </svg>
                        </span>
                        <input type="text"
                               name="nome"
                               id="nova-categoria"
                               placeholder="Nome da nova categoria (ex: Bebidas, Lanches...)"
                               required
                               autocomplete="off"
                               class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
                        />
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/25 transition-all duration-200 hover:scale-[1.02] active:scale-95 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nova Categoria
                    </button>
                </form>
                @error('nome')
                    <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Lista de categorias (drag & drop) --}}
            @if ($categorias->count() === 0)
                <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-14 text-center">
                    <div class="text-5xl mb-4">🗂️</div>
                    <p class="text-slate-700 font-bold text-lg">Nenhuma categoria cadastrada ainda</p>
                    <p class="text-slate-400 text-sm mt-1">Crie sua primeira categoria acima para começar a organizar os produtos.</p>
                </div>
            @else
                <div id="lista-categorias" class="space-y-3">
                    @foreach ($categorias as $cat)
                    <div class="categoria-item group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 cursor-grab active:cursor-grabbing"
                         data-id="{{ $cat->id }}">

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4">
                            {{-- Top block (Handle, Badge, Name & Count) --}}
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                {{-- Handle de arraste --}}
                                <div class="drag-handle p-1.5 -m-1.5 text-slate-400 hover:text-emerald-600 transition shrink-0 select-none cursor-grab active:cursor-grabbing rounded-lg hover:bg-slate-100" style="touch-action: none;" title="Clique e arraste para reordenar">
                                    <svg class="w-6 h-6 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
                                        <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
                                        <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
                                    </svg>
                                </div>

                                {{-- Badge de ordem --}}
                                <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-xs font-extrabold shrink-0 ordem-badge">
                                    {{ $loop->iteration }}
                                </div>

                                {{-- Nome (editável inline) --}}
                                <div class="flex-1 min-w-0">
                                    <span class="nome-display text-sm font-bold text-slate-800 cursor-text truncate block" title="Clique para editar">
                                        {{ $cat->nome }}
                                    </span>
                                    <form class="nome-form hidden" method="POST" action="{{ route('categorias.update', $cat) }}">
                                        @csrf @method('PUT')
                                        <input type="text"
                                               name="nome"
                                               value="{{ $cat->nome }}"
                                               class="text-sm font-bold text-slate-800 bg-transparent border-b-2 border-emerald-400 outline-none w-full"
                                               required />
                                    </form>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $cat->produtos_count }} {{ $cat->produtos_count === 1 ? 'produto' : 'produtos' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Ações --}}
                            <div class="flex items-center gap-2 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 justify-end shrink-0">
                                <a href="{{ route('categorias.produtos', $cat) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    Produtos
                                </a>

                                <button type="button"
                                        class="btn-editar-nome inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition"
                                        title="Editar nome">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </button>

                                <button type="button"
                                        class="btn-deletar inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-rose-600 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-100 transition"
                                        data-id="{{ $cat->id }}"
                                        data-nome="{{ $cat->nome }}"
                                        data-count="{{ $cat->produtos_count }}"
                                        title="Excluir categoria">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <p class="text-center text-xs text-slate-400 pt-2">
                    ☝️ Arraste as categorias para definir a ordem de exibição no app
                </p>
            @endif

        </div>
    </div>

    {{-- Modal de confirmação de exclusão --}}
    <div id="modal-deletar" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 space-y-5">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Excluir Categoria?</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed" id="modal-deletar-msg">
                    Tem certeza que deseja excluir esta categoria?
                </p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" id="btn-cancelar-deletar"
                        class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Cancelar
                </button>
                <form id="form-deletar" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="btn-confirmar-deletar"
                            class="w-full py-3 px-4 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/30 transition">
                        Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js" onload="iniciarSortable()"></script>

    <script>
        // =============================================
        // DRAG & DROP (SORTABLEJS)
        // =============================================
        function iniciarSortable() {
            const listaCategorias = document.getElementById('lista-categorias');
            if (!listaCategorias || typeof Sortable === 'undefined') return;
            if (listaCategorias.dataset.sortableInitialized) return;
            listaCategorias.dataset.sortableInitialized = 'true';

            new Sortable(listaCategorias, {
                handle: '.drag-handle',
                draggable: '.categoria-item',
                animation: 180,
                forceFallback: true,
                fallbackOnBody: true,
                fallbackTolerance: 3,
                ghostClass: 'opacity-30',
                chosenClass: 'scale-[1.01]',
                dragClass: 'shadow-2xl',
                onEnd: function () {
                    const ids = [...listaCategorias.querySelectorAll('.categoria-item')].map(function (el) {
                        return parseInt(el.dataset.id, 10);
                    });

                    // Atualiza badges de ordem visualmente
                    listaCategorias.querySelectorAll('.ordem-badge').forEach(function (badge, i) {
                        badge.textContent = i + 1;
                    });

                    // Salva no servidor
                    fetch('{{ route("categorias.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: ids })
                    })
                    .then(function (response) {
                        if (!response.ok) throw new Error('Falha ao salvar a nova ordem.');
                        return response.json();
                    })
                    .then(function (data) {
                        mostrarToastReordem('Ordem salva com sucesso!');
                    })
                    .catch(function (error) {
                        console.error('Erro na reordenação:', error);
                        mostrarToastReordem('Erro ao salvar a nova ordem.', true);
                    });
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', iniciarSortable);
        } else {
            iniciarSortable();
        }

        function mostrarToastReordem(mensagem, isError = false) {
            let toast = document.getElementById('toast-reordem');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-reordem';
                toast.className = 'fixed bottom-5 right-5 z-50 flex items-center gap-2.5 bg-slate-900 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-2xl transition-all duration-300 pointer-events-none opacity-0 translate-y-2 border border-slate-700';
                document.body.appendChild(toast);
            }

            toast.innerHTML = isError 
                ? `<span class="text-rose-400 font-extrabold">⚠️</span> <span>${mensagem}</span>` 
                : `<span class="text-emerald-400 font-extrabold">✓</span> <span>${mensagem}</span>`;

            toast.classList.remove('opacity-0', 'translate-y-2');

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
            }, 2500);
        }

        // =============================================
        // EDITAR NOME INLINE
        // =============================================
        document.querySelectorAll('.btn-editar-nome').forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.categoria-item');
                const display = card.querySelector('.nome-display');
                const form = card.querySelector('.nome-form');
                const input = form.querySelector('input');

                display.classList.add('hidden');
                form.classList.remove('hidden');
                input.focus();
                input.select();

                // Salvar ao pressionar Enter ou perder o foco
                const salvar = () => form.submit();
                input.addEventListener('keydown', e => { if (e.key === 'Enter') salvar(); });
                input.addEventListener('blur', () => {
                    display.classList.remove('hidden');
                    form.classList.add('hidden');
                }, { once: true });
            });
        });

        // =============================================
        // DELETAR COM MODAL
        // =============================================
        const modalDeletar = document.getElementById('modal-deletar');
        const formDeletar = document.getElementById('form-deletar');
        const msgDeletar = document.getElementById('modal-deletar-msg');
        const btnConfirmarDeletar = document.getElementById('btn-confirmar-deletar');
        const btnCancelarDeletar = document.getElementById('btn-cancelar-deletar');

        document.querySelectorAll('.btn-deletar').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nome = this.dataset.nome;
                const count = parseInt(this.dataset.count, 10);

                if (count > 0) {
                    msgDeletar.innerHTML = `<span class="text-rose-600 font-bold">⚠️ Não é possível excluir!</span><br>A categoria <strong>"${nome}"</strong> possui <strong>${count} produto(s)</strong>.<br>Remova os produtos antes de excluir a categoria.`;
                    if (btnConfirmarDeletar) btnConfirmarDeletar.classList.add('hidden');
                    if (btnCancelarDeletar) btnCancelarDeletar.textContent = 'Entendido';
                } else {
                    msgDeletar.innerHTML = `Tem certeza que deseja excluir a categoria <strong>"${nome}"</strong>? Esta ação não pode ser desfeita.`;
                    formDeletar.action = `/categorias/${id}`;
                    if (btnConfirmarDeletar) btnConfirmarDeletar.classList.remove('hidden');
                    if (btnCancelarDeletar) btnCancelarDeletar.textContent = 'Cancelar';
                }

                modalDeletar.classList.remove('hidden');
                modalDeletar.classList.add('flex');
            });
        });

        btnCancelarDeletar?.addEventListener('click', () => {
            modalDeletar.classList.add('hidden');
            modalDeletar.classList.remove('flex');
        });

        // Fechar ao clicar fora
        modalDeletar.addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    </script>
</x-app-layout>
