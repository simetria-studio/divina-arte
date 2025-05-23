@extends('layouts.dashboard')

@section('title', 'Nova Matéria Prima')
@section('header', 'Nova Matéria Prima')
@section('subheader', 'Cadastre uma nova matéria prima no sistema')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Informações da Matéria Prima</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados da nova matéria prima</p>
                </div>
                <a href="{{ route('materia-prima.index') }}" class="btn-secondary">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('materia-prima.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nome -->
                <div class="form-group md:col-span-2">
                    <label for="nome" class="form-label">Nome da Matéria Prima</label>
                    <input type="text"
                           name="nome"
                           id="nome"
                           value="{{ old('nome') }}"
                           class="form-input @error('nome') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite o nome da matéria prima">
                    @error('nome')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Total -->
                <div class="form-group">
                    <label for="custo_total" class="form-label">Custo Total</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                        <input type="text"
                               name="custo_total"
                               id="custo_total"
                               value="{{ old('custo_total') }}"
                               class="form-input pl-10 @error('custo_total') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00">
                    </div>
                    @error('custo_total')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Unitário (Calculado automaticamente) -->
                <div class="form-group">
                    <label for="custo_unitario" class="form-label">Custo Unitário</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                        <input type="text"
                               name="custo_unitario"
                               id="custo_unitario"
                               value="{{ old('custo_unitario') }}"
                               class="form-input pl-10 bg-gray-50 @error('custo_unitario') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00"
                               readonly>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Calculado automaticamente com base no custo total e quantidade</p>
                    @error('custo_unitario')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number"
                           name="quantidade"
                           id="quantidade"
                           value="{{ old('quantidade') }}"
                           min="0"
                           step="1"
                           class="form-input @error('quantidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('quantidade')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rendimento -->
                <div class="form-group">
                    <label for="rendimento" class="form-label">Rendimento (unidades)</label>
                    <input type="number"
                           name="rendimento"
                           id="rendimento"
                           value="{{ old('rendimento') }}"
                           min="1"
                           class="form-input @error('rendimento') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('rendimento')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Utilização -->
                <div class="form-group">
                    <label for="utilizacao" class="form-label">Utilização</label>
                    <input type="number"
                           name="utilizacao"
                           id="utilizacao"
                           value="{{ old('utilizacao') }}"
                           class="form-input bg-gray-50 @error('utilizacao') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0"
                           readonly>
                    <p class="mt-1 text-xs text-gray-500">Calculado automaticamente (1 ÷ rendimento)</p>
                    @error('utilizacao')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Utilizado -->
                <div class="form-group">
                    <label for="custo_utilizado" class="form-label">Custo Utilizado</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                        <input type="text"
                               name="custo_utilizado"
                               id="custo_utilizado"
                               value="{{ old('custo_utilizado') }}"
                               class="form-input pl-10 bg-gray-50 @error('custo_utilizado') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00"
                               readonly>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Calculado automaticamente (custo unitário × utilização)</p>
                    @error('custo_utilizado')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estoque Mínimo -->
                <div class="form-group">
                    <label for="estoque_minimo" class="form-label">Estoque Mínimo</label>
                    <input type="number"
                           name="estoque_minimo"
                           id="estoque_minimo"
                           value="{{ old('estoque_minimo') }}"
                           class="form-input @error('estoque_minimo') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('estoque_minimo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estoque Máximo -->
                <div class="form-group">
                    <label for="estoque_maximo" class="form-label">Estoque Máximo</label>
                    <input type="number"
                           name="estoque_maximo"
                           id="estoque_maximo"
                           value="{{ old('estoque_maximo') }}"
                           class="form-input @error('estoque_maximo') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('estoque_maximo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estoque Atual -->
                <div class="form-group">
                    <label for="estoque_atual" class="form-label">Estoque Atual</label>
                    <input type="number"
                           name="estoque_atual"
                           id="estoque_atual"
                           value="{{ old('estoque_atual') }}"
                           class="form-input @error('estoque_atual') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('estoque_atual')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status"
                            id="status"
                            class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="ativo" selected>Ativo</option>
                        <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end items-center pt-6 mt-6 space-x-3 border-t border-gray-100">
                <a href="{{ route('materia-prima.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Matéria Prima
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos
        const custoTotalInput = document.getElementById('custo_total');
        const quantidadeInput = document.getElementById('quantidade');
        const custoUnitarioInput = document.getElementById('custo_unitario');
        const rendimentoInput = document.getElementById('rendimento');
        const utilizacaoInput = document.getElementById('utilizacao');
        const custoUtilizadoInput = document.getElementById('custo_utilizado');

        // Máscaras para valores monetários
        const maskOptions = {
            mask: 'R$ num',
            blocks: {
                num: {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: '.',
                    padFractionalZeros: true,
                    radix: ',',
                    mapToRadix: ['.']
                }
            }
        };

        // Aplicar máscaras
        if (custoTotalInput) IMask(custoTotalInput, maskOptions);
        if (custoUnitarioInput) IMask(custoUnitarioInput, maskOptions);
        if (custoUtilizadoInput) IMask(custoUtilizadoInput, maskOptions);

        // Funções de cálculo
        function calcularCustoUnitario() {
            const custoTotal = parseFloat(custoTotalInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
            const quantidade = parseInt(quantidadeInput.value) || 1;

            if (custoTotal && quantidade) {
                const custoUnitario = custoTotal / quantidade;
                custoUnitarioInput.value = `R$ ${custoUnitario.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`;

                // Recalcula o custo utilizado após atualizar o custo unitário
                calcularCustoUtilizado();
            }
        }

        function calcularUtilizacao() {
            const rendimento = parseInt(rendimentoInput.value) || 0;
            if (rendimento > 0) {
                const utilizacao = 1 / rendimento;
                utilizacaoInput.value = utilizacao.toFixed(4);

                // Recalcula o custo utilizado após atualizar a utilização
                calcularCustoUtilizado();
            } else {
                utilizacaoInput.value = '';
            }
        }

        function calcularCustoUtilizado() {
            const custoUnitario = parseFloat(custoUnitarioInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
            const utilizacao = parseFloat(utilizacaoInput.value) || 0;

            if (custoUnitario && utilizacao) {
                const custoUtilizado = custoUnitario * utilizacao;
                custoUtilizadoInput.value = `R$ ${custoUtilizado.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`;
            }
        }

        // Event Listeners
        if (custoTotalInput) {
            custoTotalInput.addEventListener('input', calcularCustoUnitario);
        }

        if (quantidadeInput) {
            quantidadeInput.addEventListener('input', calcularCustoUnitario);
        }

        if (rendimentoInput) {
            rendimentoInput.addEventListener('input', calcularUtilizacao);
            // Calcula inicial se houver valor
            if (rendimentoInput.value) {
                calcularUtilizacao();
            }
        }

        // Cálculo inicial do custo unitário se houver valores
        if (custoTotalInput.value && quantidadeInput.value) {
            calcularCustoUnitario();
        }
    });
</script>
@endpush
@endsection