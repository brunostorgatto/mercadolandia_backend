<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0a2 2 0 012-2v-5a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 012 2m-6 0h6"></path>
                </svg>
                <span>Configurações do Meu Estabelecimento</span>
            </h2>
            <span class="text-xs text-slate-500 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full border border-emerald-200 font-medium">
                Multi-Lojas
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Flash Message -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Global Error Banner -->
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl">
                    <div class="font-semibold text-sm mb-1">Por favor, corrija os erros abaixo:</div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-slate-100">
                <div class="p-6 sm:p-8 text-gray-900">

                    <form method="POST" action="{{ route('estabelecimento.store') }}" class="space-y-8">
                        @csrf

                        <!-- Section 1: Dados do Estabelecimento -->
                        <div class="space-y-4">
                            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">1. Dados Principais & CNPJ</h3>
                                    <p class="text-xs text-slate-500">Digite o CNPJ para preencher os dados automaticamente via API pública.</p>
                                </div>
                                <span class="hidden sm:inline-block text-[11px] font-semibold text-teal-600 bg-teal-50 px-2.5 py-1 rounded-lg">
                                    Automação por API
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- CNPJ + API Button -->
                                <div class="md:col-span-2">
                                    <label for="cnpj" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        CNPJ <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <input type="text" 
                                                   id="cnpj" 
                                                   name="cnpj" 
                                                   value="{{ old('cnpj', $estabelecimento->cnpj) }}" 
                                                   required 
                                                   placeholder="Ex: 12.345.678/0001-95"
                                                   onfocus="this.select()"
                                                   oninput="mascaraCnpj(this)"
                                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                        </div>
                                        <button type="button" 
                                                id="btn-cnpj"
                                                onclick="consultarCnpj()" 
                                                class="px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5 shrink-0">
                                            <svg id="icon-search-cnpj" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span id="text-cnpj">Buscar CNPJ</span>
                                        </button>
                                    </div>
                                    <p id="msg-cnpj" class="text-xs mt-1 font-medium hidden"></p>
                                </div>

                                <!-- Razão Social -->
                                <div>
                                    <label for="razao_social" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Razão Social (Oficial da Empresa) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="razao_social" 
                                           name="razao_social" 
                                           value="{{ old('razao_social', $estabelecimento->razao_social) }}" 
                                           required 
                                           placeholder="Ex: Mercadolandia Comercio LTDA"
                                           onfocus="this.select()"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                    <p class="text-[11px] text-slate-400 mt-1">Nome jurídico registrado na Receita Federal.</p>
                                </div>

                                <!-- Nome Fantasia -->
                                <div>
                                    <label for="nome_fantasia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Nome Fantasia (Marca da Loja) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="nome_fantasia" 
                                           name="nome_fantasia" 
                                           value="{{ old('nome_fantasia', $estabelecimento->nome_fantasia) }}" 
                                           required 
                                           placeholder="Ex: Mercadolandia - Centro"
                                           onfocus="this.select()"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                    <p class="text-[11px] text-slate-400 mt-1">Nome comercial que aparecerá no topo do painel e no App.</p>
                                </div>
                            </div>
                        </div>


                        <!-- Section 2: Contato -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <div class="pb-1">
                                <h3 class="text-lg font-bold text-slate-800">2. Informações de Contato</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Telefone -->
                                <div>
                                    <label for="telefone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Telefone / WhatsApp <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="telefone" 
                                           name="telefone" 
                                           value="{{ old('telefone', $estabelecimento->telefone) }}" 
                                           required 
                                           placeholder="Ex: (51) 99999-8888"
                                           onfocus="this.select()"
                                           oninput="mascaraTelefone(this)"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- E-mail de Contato -->
                                <div>
                                    <label for="email_contato" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        E-mail de Contato <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email_contato" 
                                           name="email_contato" 
                                           value="{{ old('email_contato', $estabelecimento->email_contato) }}" 
                                           required 
                                           placeholder="contato@mercadolandia.com"
                                           onfocus="this.select()"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Endereço -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">3. Endereço da Loja</h3>
                                    <p class="text-xs text-slate-500">Digite o CEP para buscar o endereço automaticamente via ViaCEP.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- CEP -->
                                <div>
                                    <label for="cep" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        CEP <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               id="cep" 
                                               name="cep" 
                                               value="{{ old('cep', $estabelecimento->cep) }}" 
                                               required 
                                               placeholder="Ex: 90000-000"
                                               onfocus="this.select()"
                                               oninput="mascaraCep(this)"
                                               onkeyup="if(this.value.replace(/\D/g,'').length===8) consultarCep();"
                                               class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                        <button type="button" 
                                                onclick="consultarCep()" 
                                                class="px-3 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                                            Buscar
                                        </button>
                                    </div>
                                    <p id="msg-cep" class="text-xs mt-1 font-medium hidden"></p>
                                </div>


                                <!-- Logradouro -->
                                <div class="md:col-span-2">
                                    <label for="logradouro" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Logradouro / Rua <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="logradouro" 
                                           name="logradouro" 
                                           value="{{ old('logradouro', $estabelecimento->logradouro) }}" 
                                           required 
                                           placeholder="Ex: Av. Brasil"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- Número -->
                                <div>
                                    <label for="numero" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Número <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="numero" 
                                           name="numero" 
                                           value="{{ old('numero', $estabelecimento->numero) }}" 
                                           required 
                                           placeholder="123 ou S/N"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- Complemento -->
                                <div>
                                    <label for="complemento" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Complemento
                                    </label>
                                    <input type="text" 
                                           id="complemento" 
                                           name="complemento" 
                                           value="{{ old('complemento', $estabelecimento->complemento) }}" 
                                           placeholder="Ex: Loja 01, Bloco B"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- Bairro -->
                                <div>
                                    <label for="bairro" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Bairro <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="bairro" 
                                           name="bairro" 
                                           value="{{ old('bairro', $estabelecimento->bairro) }}" 
                                           required 
                                           placeholder="Ex: Centro"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- Cidade -->
                                <div class="md:col-span-2">
                                    <label for="cidade" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Cidade <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="cidade" 
                                           name="cidade" 
                                           value="{{ old('cidade', $estabelecimento->cidade) }}" 
                                           required 
                                           placeholder="Ex: Porto Alegre"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>

                                <!-- Estado (UF) -->
                                <div>
                                    <label for="estado" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        UF <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="estado" 
                                           name="estado" 
                                           maxlength="2"
                                           value="{{ old('estado', $estabelecimento->estado) }}" 
                                           required 
                                           placeholder="RS"
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm uppercase text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                                </div>
                            </div>
                        </div>

                        <!-- Action Submit -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="px-5 py-3 text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Salvar Estabelecimento</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para APIs de CNPJ e CEP -->
    <script>
        // Máscaras de entrada limpas e dinâmicas
        function mascaraCnpj(input) {
            let digits = input.value.replace(/\D/g, '');
            if (digits.length > 14) digits = digits.substring(0, 14);
            if (!digits) {
                input.value = '';
                return;
            }
            let res = digits;
            if (digits.length > 2) res = digits.substring(0,2) + '.' + digits.substring(2);
            if (digits.length > 5) res = digits.substring(0,2) + '.' + digits.substring(2,5) + '.' + digits.substring(5);
            if (digits.length > 8) res = digits.substring(0,2) + '.' + digits.substring(2,5) + '.' + digits.substring(5,8) + '/' + digits.substring(8);
            if (digits.length > 12) res = digits.substring(0,2) + '.' + digits.substring(2,5) + '.' + digits.substring(5,8) + '/' + digits.substring(8,12) + '-' + digits.substring(12);
            input.value = res;
        }

        function mascaraCep(input) {
            let digits = input.value.replace(/\D/g, '');
            if (digits.length > 8) digits = digits.substring(0, 8);
            if (!digits) {
                input.value = '';
                return;
            }
            let res = digits;
            if (digits.length > 5) {
                res = digits.substring(0,5) + '-' + digits.substring(5);
            }
            input.value = res;
        }

        function mascaraTelefone(input) {
            let digits = input.value.replace(/\D/g, '');
            if (digits.length > 11) digits = digits.substring(0, 11);
            if (!digits) {
                input.value = '';
                return;
            }
            let res = digits;
            if (digits.length > 0) res = '(' + digits;
            if (digits.length > 2) res = '(' + digits.substring(0,2) + ') ' + digits.substring(2);
            if (digits.length > 7 && digits.length <= 10) {
                res = '(' + digits.substring(0,2) + ') ' + digits.substring(2,6) + '-' + digits.substring(6);
            } else if (digits.length > 10) {
                res = '(' + digits.substring(0,2) + ') ' + digits.substring(2,7) + '-' + digits.substring(7);
            }
            input.value = res;
        }


        // Consultar CNPJ via API (BrasilAPI com fallback para ReceitaWS)
        async function consultarCnpj() {
            const rawCnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
            const msg = document.getElementById('msg-cnpj');
            const btnText = document.getElementById('text-cnpj');

            if (rawCnpj.length !== 14) {
                msg.textContent = 'Por favor, informe um CNPJ válido com 14 dígitos.';
                msg.className = 'text-xs mt-1 font-medium text-rose-600 block';
                return;
            }

            msg.textContent = 'Consultando CNPJ via API...';
            msg.className = 'text-xs mt-1 font-medium text-teal-600 block';
            btnText.textContent = 'Buscando...';

            try {
                // Tenta via BrasilAPI
                const res = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${rawCnpj}`);
                if (!res.ok) throw new Error('Falha na BrasilAPI');
                const data = await res.json();

                // Preencher Razão Social e Nome Fantasia sem inverter
                if (data.razao_social) {
                    document.getElementById('razao_social').value = data.razao_social;
                }
                
                // Se a API trouxe nome_fantasia (muitos CNPJs não têm cadastrado na Receita), usa ele; caso contrário, se estiver vazio, usa a razão social como sugestão inicial
                if (data.nome_fantasia && data.nome_fantasia.trim() !== '') {
                    document.getElementById('nome_fantasia').value = data.nome_fantasia;
                } else if (!document.getElementById('nome_fantasia').value || document.getElementById('nome_fantasia').value.trim() === '') {
                    document.getElementById('nome_fantasia').value = data.razao_social || '';
                }

                if (data.ddd_telefone_1) {
                    document.getElementById('telefone').value = data.ddd_telefone_1;
                    mascaraTelefone(document.getElementById('telefone'));
                }
                if (data.email) {
                    document.getElementById('email_contato').value = data.email.toLowerCase();
                }
                if (data.cep) {
                    document.getElementById('cep').value = data.cep;
                    mascaraCep(document.getElementById('cep'));
                    consultarCep(); // Busca o endereço a partir do CEP retornado
                }

                msg.textContent = 'CNPJ encontrado e dados preenchidos com sucesso!';
                msg.className = 'text-xs mt-1 font-medium text-emerald-600 block';
            } catch (err) {
                // Fallback para ReceitaWS via JSONP / CORS proxy ou aviso
                msg.textContent = 'Não foi possível buscar automaticamente o CNPJ. Você pode preencher os dados manualmente.';
                msg.className = 'text-xs mt-1 font-medium text-amber-600 block';
            } finally {
                btnText.textContent = 'Buscar CNPJ';
            }
        }

        // Consultar CEP via ViaCEP API
        async function consultarCep() {
            const rawCep = document.getElementById('cep').value.replace(/\D/g, '');
            const msg = document.getElementById('msg-cep');

            if (rawCep.length !== 8) {
                return;
            }

            msg.textContent = 'Buscando CEP...';
            msg.className = 'text-xs mt-1 font-medium text-teal-600 block';

            try {
                const res = await fetch(`https://viacep.com.br/ws/${rawCep}/json/`);
                const data = await res.json();

                if (data.erro) {
                    msg.textContent = 'CEP não encontrado.';
                    msg.className = 'text-xs mt-1 font-medium text-rose-600 block';
                    return;
                }

                document.getElementById('logradouro').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('estado').value = data.uf || '';

                msg.textContent = 'Endereço localizado com sucesso!';
                msg.className = 'text-xs mt-1 font-medium text-emerald-600 block';
                
                // Foca no campo número para agilizar a digitação
                document.getElementById('numero').focus();
            } catch (err) {
                msg.textContent = 'Erro ao buscar o CEP.';
                msg.className = 'text-xs mt-1 font-medium text-rose-600 block';
            }
        }
    </script>
</x-app-layout>
