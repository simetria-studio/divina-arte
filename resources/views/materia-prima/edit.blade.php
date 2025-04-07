@extends('layouts.dashboard')

@section('title', 'Editar Matéria Prima')
@section('header', 'Editar Matéria Prima')
@section('subheader', 'Atualize os dados da matéria prima')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Dados da Matéria Prima</h2>
                    <p class="mt-1 text-sm text-gray-500">Edite as informações da matéria prima</p>
                </div>
                <a href="{{ route('materia-prima.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('materia-prima.update', $materiaPrima) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="form-group md:col-span-2">
                    <label for="nome" class="form-label">Nome da Matéria Prima</label>
                    <input type="text" 
                           name="nome" 
                           id="nome" 
                           value="{{ old('nome', $materiaPrima->nome) }}"
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
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="custo_total" 
                               id="custo_total" 
                               value="{{ old('custo_total', $materiaPrima->formatted_custo_total) }}"
                               class="form-input pl-10 @error('custo_total') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00">
                    </div>
                    @error('custo_total')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" 
                           name="quantidade" 
                           id="quantidade" 
                           value="{{ old('quantidade', $materiaPrima->quantidade) }}"
                           min="0"
                           step="1"
                           class="form-input @error('quantidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('quantidade')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Unitário (Calculado automaticamente) -->
                <div class="form-group">
                    <label for="custo_unitario" class="form-label">Custo Unitário</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="custo_unitario" 
                               id="custo_unitario" 
                               value="{{ old('custo_unitario', $materiaPrima->formatted_custo_unitario) }}"
                               class="form-input pl-10 bg-gray-50 @error('custo_unitario') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00"
                               readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Calculado automaticamente com base no custo total e quantidade</p>
                    @error('custo_unitario')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rendimento -->
                <div class="form-group">
                    <label for="rendimento" class="form-label">Rendimento</label>
                    <div class="relative">
                        <input type="text" 
                               name="rendimento" 
                               id="rendimento" 
                               value="{{ old('rendimento', $materiaPrima->formatted_rendimento) }}"
                               class="form-input pr-8 @error('rendimento') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                    </div>
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
                           value="{{ old('utilizacao', $materiaPrima->utilizacao) }}"
                           min="0"
                           step="1"
                           class="form-input @error('utilizacao') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('utilizacao')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Utilizado -->
                <div class="form-group">
                    <label for="custo_utilizado" class="form-label">Custo Utilizado</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="custo_utilizado" 
                               id="custo_utilizado" 
                               value="{{ old('custo_utilizado', $materiaPrima->formatted_custo_utilizado) }}"
                               class="form-input pl-10 @error('custo_utilizado') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00">
                    </div>
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
                           value="{{ old('estoque_minimo', $materiaPrima->estoque_minimo) }}"
                           min="0"
                           step="1"
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
                           value="{{ old('estoque_maximo', $materiaPrima->estoque_maximo) }}"
                           min="0"
                           step="1"
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
                           value="{{ old('estoque_atual', $materiaPrima->estoque_atual) }}"
                           min="0"
                           step="1"
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
                        <option value="ativo" {{ old('status', $materiaPrima->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status', $materiaPrima->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3 border-t border-gray-100 pt-6">
                <a href="{{ route('materia-prima.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Atualizar Matéria Prima
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscaras para valores monetários
    const camposMonetarios = ['custo_total', 'custo_unitario', 'custo_utilizado'];
    
    camposMonetarios.forEach(campo => {
        const input = document.getElementById(campo);
        if (input) {
            IMask(input, {
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
            });
        }
    });

    // Máscara para rendimento (porcentagem)
    const rendimentoInput = document.getElementById('rendimento');
    if (rendimentoInput) {
        IMask(rendimentoInput, {
            mask: 'num%',
            blocks: {
                num: {
                    mask: Number,
                    min: 0,
                    max: 100,
                    scale: 2,
                    radix: ',',
                }
            }
        });
    }

    // Cálculo automático do custo unitário
    const custoTotalInput = document.getElementById('custo_total');
    const quantidadeInput = document.getElementById('quantidade');
    const custoUnitarioInput = document.getElementById('custo_unitario');

    function calcularCustoUnitario() {
        const custoTotal = parseFloat(custoTotalInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        const quantidade = parseInt(quantidadeInput.value) || 1;
        
        if (custoTotal && quantidade) {
            const custoUnitario = custoTotal / quantidade;
            custoUnitarioInput.value = `R$ ${custoUnitario.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }
    }

    if (custoTotalInput && quantidadeInput) {
        custoTotalInput.addEventListener('input', calcularCustoUnitario);
        quantidadeInput.addEventListener('input', calcularCustoUnitario);
    }

    // Cálculo automático do custo utilizado
    const utilizacaoInput = document.getElementById('utilizacao');
    const custoUtilizadoInput = document.getElementById('custo_utilizado');

    function calcularCustoUtilizado() {
        const custoUnitario = parseFloat(custoUnitarioInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        const utilizacao = parseInt(utilizacaoInput.value) || 0;
        
        if (custoUnitario && utilizacao) {
            const custoUtilizado = custoUnitario * utilizacao;
            custoUtilizadoInput.value = `R$ ${custoUtilizado.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }
    }

    if (utilizacaoInput) {
        utilizacaoInput.addEventListener('input', calcularCustoUtilizado);
    }
});
</script>
@endpush
@endsection 