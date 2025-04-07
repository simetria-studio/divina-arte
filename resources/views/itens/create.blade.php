@extends('layouts.dashboard')

@section('title', 'Novo Item')
@section('header', 'Novo Item')
@section('subheader', 'Adicione um novo item ao pedido')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Dados do Item</h2>
                    <p class="mt-1 text-sm text-gray-500">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('pedidos.show', $pedido) }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('pedidos.itens.store', $pedido) }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Produto -->
                <div class="form-group md:col-span-2">
                    <label for="produto_id" class="form-label">Produto</label>
                    <select name="produto_id" 
                            id="produto_id" 
                            class="form-input @error('produto_id') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" 
                                    data-preco="{{ $produto->preco_venda }}"
                                    data-custo="{{ $produto->custo }}"
                                    {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                {{ $produto->nome }} ({{ $produto->formatted_preco_venda }})
                            </option>
                        @endforeach
                    </select>
                    @error('produto_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" 
                           name="quantidade" 
                           id="quantidade" 
                           value="{{ old('quantidade', 1) }}"
                           min="1"
                           class="form-input @error('quantidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    @error('quantidade')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custo Unitário -->
                <div class="form-group">
                    <label for="custo_unitario" class="form-label">Custo Unitário</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="custo_unitario" 
                               id="custo_unitario" 
                               value="{{ old('custo_unitario', '0,00') }}"
                               class="form-input pl-10 @error('custo_unitario') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    </div>
                    @error('custo_unitario')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Desconto -->
                <div class="form-group">
                    <label for="desconto" class="form-label">Desconto</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="desconto" 
                               id="desconto" 
                               value="{{ old('desconto', '0,00') }}"
                               class="form-input pl-10 @error('desconto') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    </div>
                    @error('desconto')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valor Total (Readonly) -->
                <div class="form-group">
                    <label for="valor_total" class="form-label">Valor Total</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="valor_total" 
                               id="valor_total" 
                               value="{{ old('valor_total', '0,00') }}"
                               class="form-input pl-10 bg-gray-50"
                               readonly>
                    </div>
                    @error('valor_total')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" 
                            id="status" 
                            class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="concluido" {{ old('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3 border-t border-gray-100 pt-6">
                <a href="{{ route('pedidos.show', $pedido) }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Adicionar Item
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const produtoSelect = document.getElementById('produto_id');
    const quantidadeInput = document.getElementById('quantidade');
    const custoUnitarioInput = document.getElementById('custo_unitario');
    const descontoInput = document.getElementById('desconto');
    const valorTotalInput = document.getElementById('valor_total');

    // Máscaras para valores monetários
    IMask(custoUnitarioInput, {
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

    IMask(descontoInput, {
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

    // Função para calcular o valor total
    function calcularValorTotal() {
        const quantidade = parseInt(quantidadeInput.value) || 0;
        const custoUnitario = parseFloat(custoUnitarioInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        const desconto = parseFloat(descontoInput.value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        
        const valorTotal = (quantidade * custoUnitario) - desconto;
        
        valorTotalInput.value = `R$ ${valorTotal.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    }

    // Event Listeners
    if (produtoSelect) {
        produtoSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const custo = option.dataset.custo || 0;
            
            custoUnitarioInput.value = `R$ ${parseFloat(custo).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
            
            calcularValorTotal();
        });
    }

    if (quantidadeInput) {
        quantidadeInput.addEventListener('input', calcularValorTotal);
    }

    if (descontoInput) {
        descontoInput.addEventListener('input', calcularValorTotal);
    }

    if (custoUnitarioInput) {
        custoUnitarioInput.addEventListener('input', calcularValorTotal);
    }
});
</script>
@endpush
@endsection 