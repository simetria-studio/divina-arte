@extends('layouts.dashboard')

@section('title', 'Novo Cliente')
@section('header', 'Novo Cliente')
@section('subheader', 'Cadastre um novo cliente no sistema')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Informações do Cliente</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados do novo cliente</p>
                </div>
                <a href="{{ route('clientes.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="form-group">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" 
                           name="nome" 
                           id="nome" 
                           value="{{ old('nome') }}"
                           class="form-input @error('nome') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite o nome completo">
                    @error('nome')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           class="form-input @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite o email">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="form-group">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" 
                           name="telefone" 
                           id="telefone" 
                           value="{{ old('telefone') }}"
                           class="form-input @error('telefone') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="(00) 00000-0000">
                    @error('telefone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CEP com busca automática -->
                <div class="form-group">
                    <label for="cep" class="form-label">CEP</label>
                    <div class="relative">
                        <input type="text" 
                               name="cep" 
                               id="cep" 
                               value="{{ old('cep') }}"
                               class="form-input @error('cep') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="00000-000">
                        <button type="button" 
                                id="buscarCep"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <div id="cepLoading" class="hidden absolute right-2 top-1/2 -translate-y-1/2">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-purple-900"></div>
                        </div>
                    </div>
                    <p id="cepError" class="hidden form-error">CEP não encontrado</p>
                    @error('cep')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Endereço -->
                <div class="form-group md:col-span-2">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" 
                           name="endereco" 
                           id="endereco" 
                           value="{{ old('endereco') }}"
                           class="form-input @error('endereco') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite o endereço completo">
                    @error('endereco')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cidade -->
                <div class="form-group">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" 
                           name="cidade" 
                           id="cidade" 
                           value="{{ old('cidade') }}"
                           class="form-input @error('cidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite a cidade">
                    @error('cidade')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="form-group">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" 
                            id="estado" 
                            class="form-input @error('estado') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="">Selecione o estado</option>
                        @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                            <option value="{{ $uf }}" {{ old('estado') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3 border-t border-gray-100 pt-6">
                <a href="{{ route('clientes.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Aguarde o DOM estar pronto
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM carregado');
        
        // Elementos do formulário
        const telefoneInput = document.getElementById('telefone');
        const cepInput = document.getElementById('cep');
        const buscarCepBtn = document.getElementById('buscarCep');
        const cepLoading = document.getElementById('cepLoading');
        const cepError = document.getElementById('cepError');
        const enderecoInput = document.getElementById('endereco');
        const cidadeInput = document.getElementById('cidade');
        const estadoInput = document.getElementById('estado');

        // Aplicar máscaras
        if (telefoneInput) {
            IMask(telefoneInput, {
                mask: '(00) 00000-0000'
            });
        }

        if (cepInput) {
            IMask(cepInput, {
                mask: '00000-000'
            });
        }

        // Função para buscar CEP
        async function consultarCep() {
            const cep = cepInput.value.replace(/\D/g, '');
            
            if (cep.length !== 8) {
                alert('Por favor, digite um CEP válido');
                return;
            }

            try {
                buscarCepBtn.classList.add('hidden');
                cepLoading.classList.remove('hidden');
                cepError.classList.add('hidden');

                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    throw new Error('CEP não encontrado');
                }

                enderecoInput.value = data.logradouro;
                cidadeInput.value = data.localidade;
                estadoInput.value = data.uf;

                cepInput.classList.remove('input-error');
                cepInput.classList.add('input-success');
                
                setTimeout(() => {
                    cepInput.classList.remove('input-success');
                }, 2000);

            } catch (error) {
                console.error('Erro ao buscar CEP:', error);
                
                cepError.classList.remove('hidden');
                cepInput.classList.remove('input-success');
                cepInput.classList.add('input-error');
                
                enderecoInput.value = '';
                cidadeInput.value = '';
                estadoInput.value = '';

                setTimeout(() => {
                    cepInput.classList.remove('input-error');
                }, 2000);

            } finally {
                buscarCepBtn.classList.remove('hidden');
                cepLoading.classList.add('hidden');
            }
        }

        // Event Listeners
        if (buscarCepBtn) {
            buscarCepBtn.addEventListener('click', (e) => {
                e.preventDefault();
                consultarCep();
            });
        }

        if (cepInput) {
            cepInput.addEventListener('blur', consultarCep);
            
            cepInput.addEventListener('input', () => {
                cepError.classList.add('hidden');
                cepInput.classList.remove('input-error', 'input-success');
            });
        }
    });
</script>
@endpush
@endsection 