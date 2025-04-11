@extends('layouts.dashboard')

@section('title', 'Editar Item')
@section('header', 'Editar Item')
@section('subheader', 'Edite as informações do item do pedido')

@section('content')
    <div class="mx-auto max-w-5xl">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Dados do Item</h2>
                        <p class="mt-1 text-sm text-gray-500">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn-secondary">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
            @foreach ($itens as $item)

                <form action="{{ route('pedidos.itens.update', ['pedido' => $pedido, 'item' => $item]) }}"
                    method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Produto -->
                        <div class="form-group md:col-span-2">
                            <label for="produto_id" class="form-label">Produto</label>
                            <select name="produto_id" id="produto_id"
                                class="form-input @error('produto_id') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                <option value="">Selecione um produto</option>
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}"
                                        data-custo="{{ $produto->custo }}"
                                        {{ old('produto_id', $item->produto_id) == $produto->id ? 'selected' : '' }}>
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
                            <input type="number" name="quantidade" id="quantidade"
                                value="{{ old('quantidade', $item->quantidade) }}" min="1"
                                class="form-input @error('quantidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            @error('quantidade')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Custo Unitário -->
                        <div class="form-group">
                            <label for="custo_unitario" class="form-label">Custo Unitário</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                                <input type="text" name="custo_unitario" id="custo_unitario"
                                    value="{{ old('custo_unitario', number_format($item->custo_unitario, 2, ',', '.')) }}"
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
                                <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                                <input type="text" name="desconto" id="desconto"
                                    value="{{ old('desconto', number_format($item->desconto, 2, ',', '.')) }}"
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
                                <span class="absolute left-3 top-1/2 text-gray-500 -translate-y-1/2">R$</span>
                                <input type="text" name="valor_total" id="valor_total"
                                    value="{{ old('valor_total', number_format($item->valor_total, 2, ',', '.')) }}"
                                    class="pl-10 bg-gray-50 form-input" readonly>
                            </div>
                            @error('valor_total')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status"
                                class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                <option value="pendente"
                                    {{ old('status', $item->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="concluido"
                                    {{ old('status', $item->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                <option value="cancelado"
                                    {{ old('status', $item->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end items-center pt-6 mt-6 space-x-3 border-t border-gray-100">
                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Atualizar Item
                        </button>
                    </div>
                </form>
            @endforeach

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Máscaras para valores monetários
                const camposMonetarios = ['custo_unitario', 'desconto', 'valor_total'];

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

                // Atualiza o custo unitário quando o produto é alterado
                document.getElementById('produto_id').addEventListener('change', function() {
                    const option = this.options[this.selectedIndex];
                    if (option && option.value) {
                        const custo = parseFloat(option.dataset.custo);
                        document.getElementById('custo_unitario').value = custo.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        });
                        calcularValorTotal();
                    }
                });

                // Calcula o valor total quando quantidade, custo ou desconto são alterados
                ['quantidade', 'custo_unitario', 'desconto'].forEach(campo => {
                    document.getElementById(campo).addEventListener('input', calcularValorTotal);
                });

                function calcularValorTotal() {
                    const quantidade = parseInt(document.getElementById('quantidade').value) || 0;
                    const custoUnitario = parseFloat(document.getElementById('custo_unitario').value.replace('R$', '')
                        .replace(/\./g, '').replace(',', '.')) || 0;
                    const desconto = parseFloat(document.getElementById('desconto').value.replace('R$', '').replace(
                        /\./g, '').replace(',', '.')) || 0;

                    const valorTotal = (quantidade * custoUnitario) - desconto;

                    document.getElementById('valor_total').value = valorTotal.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            });
        </script>
    @endpush
@endsection
