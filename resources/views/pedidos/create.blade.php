@extends('layouts.dashboard')

@section('title', 'Novo Pedido')
@section('header', 'Novo Pedido')
@section('subheader', 'Cadastre um novo pedido no sistema')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Informações do Pedido</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados do novo pedido</p>
                </div>
                <a href="{{ route('pedidos.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('pedidos.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-8">
                <!-- Dados do Pedido -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Pedido</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cliente -->
                        <div class="form-group md:col-span-2">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select name="cliente_id" 
                                    id="cliente_id" 
                                    class="form-input @error('cliente_id') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                <option value="">Selecione um cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data de Entrega -->
                        <div class="form-group">
                            <label for="data_entrega" class="form-label">Data de Entrega</label>
                            <input type="date" 
                                   name="data_entrega" 
                                   id="data_entrega" 
                                   value="{{ old('data_entrega', date('Y-m-d', strtotime('+7 days'))) }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="form-input @error('data_entrega') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            @error('data_entrega')
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
                                <option value="em_producao" {{ old('status') == 'em_producao' ? 'selected' : '' }}>Em Produção</option>
                                <option value="concluido" {{ old('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Itens do Pedido -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Itens do Pedido</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Produto</th>
                                    <th class="px-4 py-2 text-center">Quantidade</th>
                                    <th class="px-4 py-2 text-center">Custo Unitário</th>
                                    <th class="px-4 py-2 text-center">Desconto</th>
                                    <th class="px-4 py-2 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="itens-container">
                                <!-- Os itens serão adicionados aqui -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="px-4 py-2">
                                        <button type="button" 
                                                class="btn-secondary w-full"
                                                onclick="adicionarItem()">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Adicionar Item
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Totais -->
                    <div class="mt-6 flex justify-end">
                        <div class="w-72 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-medium">Custo Total:</span>
                                <span id="custo-total" class="text-gray-900">R$ 0,00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-medium">Desconto Total:</span>
                                <span id="desconto-total" class="text-gray-900">R$ 0,00</span>
                            </div>
                            <div class="flex justify-between items-center text-base pt-3 border-t">
                                <span class="font-medium">Valor Total:</span>
                                <span id="valor-total" class="font-bold text-gray-900">R$ 0,00</span>
                                <input type="hidden" name="valor_total" id="valor-total-input" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3 border-t border-gray-100 pt-6">
                <a href="{{ route('pedidos.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Criar Pedido
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Após criar o pedido, você poderá adicionar os itens na próxima tela. Os valores totais serão calculados automaticamente.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let contadorItens = 0;

const templateItem = `
    <tr class="border-t">
        <td class="px-4 py-2">
            <select name="itens[INDEX][produto_id]" 
                    class="form-input produto-select w-full"
                    onchange="atualizarCusto(this)"
                    required>
                <option value="">Selecione um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" 
                            data-preco="{{ $produto->preco_venda }}">
                        {{ $produto->nome }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="px-4 py-2">
            <input type="number" 
                   name="itens[INDEX][quantidade]" 
                   value="1"
                   min="1"
                   class="form-input quantidade-input text-center w-24"
                   onchange="calcularTotais()">
        </td>
        <td class="px-4 py-2">
            <div class="relative w-36 mx-auto">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                <input type="text" 
                       name="itens[INDEX][custo_unitario]" 
                       value="0,00"
                       class="form-input pl-10 custo-input text-center"
                       onchange="calcularTotais()">
            </div>
        </td>
        <td class="px-4 py-2">
            <div class="relative w-36 mx-auto">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                <input type="text" 
                       name="itens[INDEX][desconto]" 
                       value="0,00"
                       class="form-input pl-10 desconto-input text-center"
                       onchange="calcularTotais()">
            </div>
        </td>
        <td class="px-4 py-2 text-center">
            <button type="button" 
                    class="text-red-600 hover:text-red-800"
                    onclick="removerItem(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            <input type="hidden" name="itens[INDEX][valor_total]" value="0.00">
        </td>
    </tr>
`;

function adicionarItem() {
    const container = document.getElementById('itens-container');
    const novoItem = document.createElement('tr');
    novoItem.innerHTML = templateItem.replace(/INDEX/g, contadorItens);
    container.appendChild(novoItem);
    
    // Aplica máscaras aos novos inputs
    aplicarMascaras(novoItem);
    
    contadorItens++;
}

function removerItem(button) {
    button.closest('tr').remove();
    calcularTotais();
}

function aplicarMascaras(item) {
    const custoInput = item.querySelector('.custo-input');
    const descontoInput = item.querySelector('.desconto-input');
    
    IMask(custoInput, {
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
}

function calcularTotais() {
    let custoTotal = 0;
    let descontoTotal = 0;
    let valorTotal = 0;

    document.querySelectorAll('#itens-container tr').forEach(item => {
        const quantidade = parseInt(item.querySelector('.quantidade-input').value) || 0;
        const custoUnitario = parseFloat(item.querySelector('.custo-input').value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        const desconto = parseFloat(item.querySelector('.desconto-input').value.replace('R$ ', '').replace(/\./g, '').replace(',', '.')) || 0;
        
        const custoItem = quantidade * custoUnitario;
        const valorItem = custoItem - desconto;
        
        custoTotal += custoItem;
        descontoTotal += desconto;
        valorTotal += valorItem;

        // Atualiza o valor_total do item
        item.querySelector('input[name$="[valor_total]"]').value = valorItem.toFixed(2);
    });

    // Atualiza os displays
    document.getElementById('custo-total').textContent = formatarMoeda(custoTotal);
    document.getElementById('desconto-total').textContent = formatarMoeda(descontoTotal);
    document.getElementById('valor-total').textContent = formatarMoeda(valorTotal);
    document.getElementById('valor-total-input').value = valorTotal;
}

function formatarMoeda(valor) {
    return `R$ ${valor.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}`;
}

function atualizarCusto(select) {
    const item = select.closest('tr');
    const option = select.options[select.selectedIndex];
    const custoInput = item.querySelector('.custo-input');
    
    if (option && option.value) {
        // Pega o preço de venda do produto do data attribute
        const preco = parseFloat(option.dataset.preco);
        
        // Atualiza o input com o preço formatado
        custoInput.value = formatarMoeda(preco);
        
        // Recalcula os totais
        calcularTotais();
    }
}

// Adiciona o primeiro item ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    adicionarItem();
});
</script>
@endpush
@endsection 