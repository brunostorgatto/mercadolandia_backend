<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('categorias.index') }}"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Categorias</p>
                    <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">{{ $categoria->nome }}</h1>
                </div>
            </div>
            <button type="button"
                id="btn-abrir-modal-novo"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/25 transition-all hover:scale-[1.02] active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Adicionar Produto
            </button>
        </div>
    </x-slot>

    {{-- Toasts --}}
    @if (session('success'))
    <div id="toast-ok" class="fixed top-20 right-5 z-50 flex items-center gap-3 bg-white border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3.5 rounded-2xl shadow-xl transition-all">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-ok');
            if (t) t.style.opacity = '0';
        }, 3500);
    </script>
    @endif

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Grid de produtos --}}
            @if ($produtos->count() === 0)
            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-20 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <p class="text-slate-700 font-bold text-xl">Nenhum produto nesta categoria ainda</p>
                <p class="text-slate-400 text-sm mt-2">Clique em "Adicionar Produto" para começar.</p>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($produtos as $produto)
                <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-slate-300 transition-all duration-200 overflow-hidden flex flex-col">

                    {{-- Foto do produto --}}
                    <div class="relative aspect-square bg-slate-100 overflow-hidden">
                        @if ($produto->foto_url)
                        <img src="{{ $produto->foto_url }}"
                            alt="{{ $produto->nome }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        @else
                        {{-- Ícone padrão caso não tenha foto --}}
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif

                        {{-- Overlay de ações --}}
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-2">
                            <button type="button"
                                class="btn-editar-produto w-9 h-9 rounded-xl bg-white text-slate-700 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition shadow-md"
                                data-produto='{{ json_encode(["id" => $produto->id, "nome" => $produto->nome, "preco" => $produto->preco, "unidade_medida" => $produto->unidade_medida, "incremento" => $produto->incremento, "foto_url" => $produto->foto_url]) }}'
                                title="Editar produto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="btn-deletar-produto w-9 h-9 rounded-xl bg-white text-slate-700 hover:bg-rose-500 hover:text-white flex items-center justify-center transition shadow-md"
                                data-id="{{ $produto->id }}"
                                data-nome="{{ $produto->nome }}"
                                title="Excluir produto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-3 flex flex-col gap-1 flex-1">
                        <p class="text-xs font-bold text-slate-800 leading-snug line-clamp-2">{{ $produto->nome }}</p>
                        <div class="flex items-center justify-between mt-auto pt-1">
                            <span class="text-sm font-extrabold text-emerald-700">
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </span>
                            <span class="text-[10px] font-bold uppercase text-slate-500 bg-slate-100 rounded-lg px-2 py-0.5">
                                {{ $produto->unidade_medida }}
                            </span>
                        </div>
                        @if ($produto->incremento != 1)
                        <p class="text-[10px] text-slate-400">Incremento: {{ $produto->incremento }} {{ $produto->unidade_medida }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ======================================================
         MODAL: CRIAR / EDITAR PRODUTO
    ====================================================== --}}
    <div id="modal-produto" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl border border-slate-100 flex flex-col max-h-[95vh] overflow-y-auto">

            {{-- Header do Modal --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 shrink-0">
                <div>
                    <h2 id="modal-titulo" class="text-lg font-extrabold text-slate-900">Novo Produto</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Categoria: <strong>{{ $categoria->nome }}</strong></p>
                </div>
                <button type="button" id="btn-fechar-modal"
                    class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Formulário --}}
            <form id="form-produto" method="POST" action="{{ route('produtos.store', $categoria) }}" class="p-6 space-y-5">
                @csrf
                <span id="method-field"></span>

                {{-- ---- FOTO COM CROPPER ---- --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Foto do Produto</label>

                    {{-- Área de upload / preview 1:1 --}}
                    <div id="zona-upload"
                        class="relative w-full max-w-[200px] aspect-square mx-auto border-2 border-dashed border-slate-300 hover:border-emerald-400 rounded-2xl transition-colors cursor-pointer overflow-hidden flex items-center justify-center bg-slate-50">

                        {{-- Estado vazio --}}
                        <div id="upload-placeholder" class="flex flex-col items-center justify-center gap-1.5 p-4 text-center text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs font-semibold">Escolher foto</p>
                            <p class="text-[10px] text-slate-400">Quadrado 1:1</p>
                        </div>

                        {{-- Preview da imagem --}}
                        <img id="preview-recortada" src="" alt="Preview" class="hidden w-full h-full object-cover rounded-2xl" />

                        <input type="file" id="input-foto" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />
                    </div>

                    {{-- Botões de Ação da Foto --}}
                    <div class="flex items-center justify-between max-w-[200px] mx-auto mt-2">
                        <button type="button" id="btn-trocar-foto" class="hidden text-xs font-semibold text-emerald-600 hover:underline">
                            🔄 Trocar
                        </button>
                        <button type="button" id="btn-remover-foto" class="hidden text-xs font-semibold text-rose-600 hover:underline">
                            🗑️ Remover foto
                        </button>
                    </div>

                    {{-- Campos Ocultos --}}
                    <input type="hidden" name="imagem_base64" id="imagem_base64" />
                    <input type="hidden" name="remover_imagem" id="remover_imagem" value="0" />
                </div>

                {{-- Nome --}}
                <div>
                    <label for="produto-nome" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nome do Produto <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                        id="produto-nome"
                        name="nome"
                        placeholder="Ex: Coca-Cola 2L, Pão Francês, Banana..."
                        required
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                </div>

                {{-- Preço + Unidade --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="produto-preco-display" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Preço (R$) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400 pointer-events-none">R$</span>
                            <input type="text"
                                id="produto-preco-display"
                                inputmode="numeric"
                                placeholder="0,00"
                                required
                                autocomplete="off"
                                class="block w-full pl-9 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                        </div>
                        <input type="hidden" id="produto-preco" name="preco" />
                    </div>
                    <div>
                        <label for="produto-unidade" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Unidade <span class="text-rose-500">*</span>
                        </label>
                        <select id="produto-unidade"
                            name="unidade_medida"
                            required
                            class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                            <option value="un">un — Unidade</option>
                            <option value="kg">kg — Quilograma</option>
                            <option value="g">g — Grama</option>
                            <option value="l">l — Litro</option>
                        </select>
                    </div>
                </div>

                {{-- Incremento --}}
                <div>
                    <label for="produto-incremento" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Incremento de Quantidade
                    </label>
                    <input type="number"
                        id="produto-incremento"
                        name="incremento"
                        placeholder="1"
                        min="0.001"
                        step="0.001"
                        value="1"
                        required
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                    <p class="text-[11px] text-slate-400 mt-1">
                        Ex: <strong>1</strong> para unidades, <strong>0.5</strong> para meio-quilo, <strong>0.1</strong> para 100g.
                    </p>
                </div>

                {{-- Botões --}}
                <div class="flex gap-3 pt-2">
                    <button type="button" id="btn-cancelar-modal"
                        class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-salvar-produto"
                        class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all hover:scale-[1.02] active:scale-95">
                        Salvar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ======================================================
         MODAL: CROPPER DE IMAGEM
    ====================================================== --}}
    <div id="modal-cropper" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-900">✂️ Recortar Foto</h3>
                <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full font-semibold">Formato quadrado 1:1</span>
            </div>
            <div class="p-4 bg-slate-900">
                <div style="max-height: 380px; overflow: hidden;">
                    <img id="imagem-para-crop" src="" alt="Imagem para recortar" class="block max-w-full" />
                </div>
            </div>
            <div class="px-6 py-4 flex gap-3">
                <button type="button" id="btn-cancelar-crop"
                    class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition">
                    Cancelar
                </button>
                <button type="button" id="btn-confirmar-crop"
                    class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition">
                    ✅ Confirmar Recorte
                </button>
            </div>
        </div>
    </div>

    {{-- Modal de exclusão do produto --}}
    <div id="modal-deletar-produto" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 space-y-5">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Excluir Produto?</h3>
                <p id="msg-deletar-produto" class="text-xs text-slate-500 mt-1.5 leading-relaxed"></p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" id="btn-cancelar-deletar-produto"
                    class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Cancelar
                </button>
                <form id="form-deletar-produto" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="py-3 px-5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/30 transition">
                        Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMAÇÃO DE REMOÇÃO DE FOTO (COM Z-INDEX 80 FORA DO MODAL PRINCIPAL) --}}
    <div id="modal-confirmar-remover-foto" class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 space-y-5 relative z-[81]">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Remover Foto?</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Você tem certeza que deseja apagar a foto deste produto? A imagem será excluída permanentemente.</p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" id="btn-cancelar-remover-foto"
                    class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Cancelar
                </button>
                <button type="button" id="btn-confirmar-remover-foto"
                    class="flex-1 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/30 transition">
                    Sim, Remover
                </button>
            </div>
        </div>
    </div>

    {{-- Cropper.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>

    <script>
        // =============================================
        // MÁSCARA DE MOEDA
        // =============================================
        function aplicarMascaraMoeda(input) {
            input.addEventListener('input', function() {
                let digits = this.value.replace(/\D/g, '');
                if (!digits) {
                    this.value = '';
                    document.getElementById('produto-preco').value = '';
                    return;
                }
                let cents = parseInt(digits, 10);
                let reais = Math.floor(cents / 100);
                let centavos = cents % 100;
                let formatted = reais.toLocaleString('pt-BR') + ',' + String(centavos).padStart(2, '0');
                this.value = formatted;
                document.getElementById('produto-preco').value = (cents / 100).toFixed(2);
            });
        }

        // =============================================
        // MODAL PRODUTO: Abrir / Fechar
        // =============================================
        const modalProduto = document.getElementById('modal-produto');
        const formProduto = document.getElementById('form-produto');
        const modalTitulo = document.getElementById('modal-titulo');
        const methodField = document.getElementById('method-field');

        const previewRecortada = document.getElementById('preview-recortada');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const btnTrocarFoto = document.getElementById('btn-trocar-foto');
        const btnRemoverFoto = document.getElementById('btn-remover-foto');
        const inputImagemBase64 = document.getElementById('imagem_base64');
        const inputRemoverImagem = document.getElementById('remover_imagem');

        const modalConfirmarRemoverFoto = document.getElementById('modal-confirmar-remover-foto');
        let produtoAtualEdicao = null;

        function resetFotoArea() {
            inputImagemBase64.value = '';
            inputRemoverImagem.value = '0';
            previewRecortada.src = '';
            previewRecortada.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            btnTrocarFoto.classList.add('hidden');
            btnRemoverFoto.classList.add('hidden');
            document.getElementById('input-foto').value = '';
        }

        function abrirModal(modo = 'criar', produto = null) {
            formProduto.reset();
            resetFotoArea();
            produtoAtualEdicao = produto;

            document.getElementById('produto-preco-display').value = '';
            document.getElementById('produto-preco').value = '';

            if (modo === 'criar') {
                modalTitulo.textContent = 'Novo Produto';
                formProduto.action = "{{ route('produtos.store', $categoria) }}";
                methodField.innerHTML = '';
            } else {
                modalTitulo.textContent = 'Editar Produto';
                formProduto.action = `/produtos/${produto.id}`;
                methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

                document.getElementById('produto-nome').value = produto.nome;
                const precoFloat = parseFloat(produto.preco);
                document.getElementById('produto-preco-display').value = precoFloat.toFixed(2).replace('.', ',');
                document.getElementById('produto-preco').value = precoFloat.toFixed(2);
                document.getElementById('produto-unidade').value = produto.unidade_medida;
                document.getElementById('produto-incremento').value = produto.incremento;

                if (produto.foto_url) {
                    previewRecortada.src = produto.foto_url;
                    previewRecortada.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    btnTrocarFoto.classList.remove('hidden');
                    btnRemoverFoto.classList.remove('hidden');
                }
            }

            modalProduto.classList.remove('hidden');
            modalProduto.classList.add('flex');
            setTimeout(() => document.getElementById('produto-nome').focus(), 100);
        }

        function fecharModal() {
            modalProduto.classList.add('hidden');
            modalProduto.classList.remove('flex');
        }

        aplicarMascaraMoeda(document.getElementById('produto-preco-display'));

        document.getElementById('btn-abrir-modal-novo').addEventListener('click', () => abrirModal('criar'));
        document.getElementById('btn-fechar-modal').addEventListener('click', fecharModal);
        document.getElementById('btn-cancelar-modal').addEventListener('click', fecharModal);

        modalProduto.addEventListener('click', e => {
            if (e.target === modalProduto) fecharModal();
        });

        document.querySelectorAll('.btn-editar-produto').forEach(btn => {
            btn.addEventListener('click', function() {
                const produto = JSON.parse(this.dataset.produto);
                abrirModal('editar', produto);
            });
        });

        // Clique no botão "Remover Foto" no formulário
        btnRemoverFoto.addEventListener('click', () => {
            if (produtoAtualEdicao && produtoAtualEdicao.foto_url && inputImagemBase64.value === '') {
                modalConfirmarRemoverFoto.classList.remove('hidden');
                modalConfirmarRemoverFoto.classList.add('flex');
            } else {
                resetFotoArea();
            }
        });

        // Fechar confirmação de remoção de foto
        document.getElementById('btn-cancelar-remover-foto').addEventListener('click', () => {
            modalConfirmarRemoverFoto.classList.add('hidden');
            modalConfirmarRemoverFoto.classList.remove('flex');
        });

        modalConfirmarRemoverFoto.addEventListener('click', e => {
            if (e.target === modalConfirmarRemoverFoto) {
                modalConfirmarRemoverFoto.classList.add('hidden');
                modalConfirmarRemoverFoto.classList.remove('flex');
            }
        });

        // Confirmar remoção e submeter sinalização para o backend
        document.getElementById('btn-confirmar-remover-foto').addEventListener('click', () => {
            inputRemoverImagem.value = '1';
            modalConfirmarRemoverFoto.classList.add('hidden');
            modalConfirmarRemoverFoto.classList.remove('flex');

            formProduto.submit();
        });

        // =============================================
        // CROPPER.JS
        // =============================================
        const modalCropper = document.getElementById('modal-cropper');
        const imgParaCrop = document.getElementById('imagem-para-crop');
        const inputFoto = document.getElementById('input-foto');
        let cropperInstance = null;

        function abrirCropper(src) {
            imgParaCrop.src = src;
            modalCropper.classList.remove('hidden');
            modalCropper.classList.add('flex');

            setTimeout(() => {
                if (cropperInstance) cropperInstance.destroy();
                cropperInstance = new Cropper(imgParaCrop, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 0.9,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    background: false,
                    guides: true,
                    center: true,
                    highlight: false,
                });
            }, 200);
        }

        function fecharCropper() {
            modalCropper.classList.add('hidden');
            modalCropper.classList.remove('flex');
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
            inputFoto.value = '';
        }

        inputFoto.addEventListener('change', function() {
            if (!this.files || !this.files[0]) return;

            const reader = new FileReader();
            reader.onload = e => abrirCropper(e.target.result);
            reader.readAsDataURL(this.files[0]);
        });

        document.getElementById('btn-confirmar-crop').addEventListener('click', function() {
            if (!cropperInstance) return;

            const canvas = cropperInstance.getCroppedCanvas({
                width: 600,
                height: 600,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const base64 = canvas.toDataURL('image/jpeg', 0.88);
            inputImagemBase64.value = base64;
            inputRemoverImagem.value = '0';

            previewRecortada.src = base64;
            previewRecortada.classList.remove('hidden');
            uploadPlaceholder.classList.add('hidden');
            btnTrocarFoto.classList.remove('hidden');
            btnRemoverFoto.classList.remove('hidden');

            fecharCropper();
        });

        document.getElementById('btn-cancelar-crop').addEventListener('click', fecharCropper);

        btnTrocarFoto.addEventListener('click', () => {
            inputFoto.value = '';
            inputFoto.click();
        });

        // =============================================
        // DELETAR PRODUTO
        // =============================================
        const modalDeletarProduto = document.getElementById('modal-deletar-produto');

        document.querySelectorAll('.btn-deletar-produto').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nome = this.dataset.nome;

                document.getElementById('msg-deletar-produto').innerHTML =
                    `Tem certeza que deseja excluir o produto <strong>"${nome}"</strong>? Esta ação é irreversível.`;
                document.getElementById('form-deletar-produto').action = `/produtos/${id}`;

                modalDeletarProduto.classList.remove('hidden');
                modalDeletarProduto.classList.add('flex');
            });
        });

        document.getElementById('btn-cancelar-deletar-produto').addEventListener('click', () => {
            modalDeletarProduto.classList.add('hidden');
            modalDeletarProduto.classList.remove('flex');
        });

        modalDeletarProduto.addEventListener('click', e => {
            if (e.target === modalDeletarProduto) {
                modalDeletarProduto.classList.add('hidden');
                modalDeletarProduto.classList.remove('flex');
            }
        });
    </script>
</x-app-layout>