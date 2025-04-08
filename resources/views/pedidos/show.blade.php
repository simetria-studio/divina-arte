@extends('layouts.dashboard')

@section('title', 'Detalhes do Pedido')
@section('header', 'Detalhes do Pedido')
@section('subheader', 'Visualize e gerencie os detalhes do pedido')

@section('content')
<div class="mx-auto space-y-6 max-w-7xl">
    <!-- Cabeçalho do Pedido -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">
                        Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Cliente: {{ $pedido->cliente->nome ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex gap-3 items-center">
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn-secondary">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Pedido
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="btn-secondary">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Informações do Pedido -->
        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Data de Entrega</label>
                <p class="mt-1 text-lg text-gray-900">{{ $pedido->data_entrega->format('d/m/Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="mt-1">
                    @if($pedido->status === 'concluido')
                        <span class="status-tag status-active">Concluído</span>
                    @elseif($pedido->status === 'em_producao')
                        <span class="status-tag status-pending">Em Produção</span>
                    @elseif($pedido->status === 'pendente')
                        <span class="status-tag status-pending">Pendente</span>
                    @else
                        <span class="status-tag status-inactive">Cancelado</span>
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Custo Total</label>
                <p class="mt-1 text-lg text-gray-900">{{ $pedido->formatted_custo_total }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Valor Total</label>
                <p class="mt-1 text-lg text-gray-900">{{ $pedido->formatted_valor_total }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lucro</label>
                <p class="mt-1 text-lg text-gray-900">{{ $pedido->formatted_lucro }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lucro Percentual</label>
                <p class="mt-1 text-lg text-gray-900">{{ $pedido->formatted_lucro_percentual }}</p>
            </div>
        </div>
    </div>

    <!-- Lista de Itens -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Itens do Pedido</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $pedido->itens->count() }} itens no pedido</p>
                </div>
                <a href="{{ route('pedidos.itens.create', $pedido) }}" class="btn-primary">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Adicionar Item
                </a>
            </div>
        </div>

        @if($pedido->itens->isEmpty())
            <div class="p-6 text-center">
                <div class="inline-flex justify-center items-center mb-4 w-16 h-16 bg-gray-100 rounded-full">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <p class="text-gray-500">Nenhum item adicionado ao pedido ainda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Custo Unitário</th>
                            <th>Desconto</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th width="100">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->itens as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->produto->nome ?? 'N/A' }}</td>
                                <td>{{ $item->quantidade ?? 'N/A' }}</td>
                                <td>{{ $item->formatted_custo_unitario ?? 'N/A' }}</td>
                                <td>{{ $item->formatted_desconto ?? 'N/A' }}</td>
                                <td>{{ $item->formatted_valor_total ?? 'N/A' }}</td>
                                <td>
                                    @if($item->status === 'concluido')
                                        <span class="status-tag status-active">Concluído</span>
                                    @elseif($item->status === 'pendente')
                                        <span class="status-tag status-pending">Pendente</span>
                                    @else
                                        <span class="status-tag status-inactive">Cancelado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2 items-center">
                                        <a href="{{ route('pedidos.itens.edit', [$pedido, $item]) }}"
                                           class="btn-icon"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('pedidos.itens.destroy', [$pedido, $item]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-icon hover:text-red-600"
                                                    title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection