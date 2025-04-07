@extends('layouts.dashboard')

@section('title', 'Pedidos')
@section('header', 'Pedidos')
@section('subheader', 'Gerencie os pedidos do sistema')

@section('content')
<div class="space-y-6">
    <!-- Header/Search Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex-1">
            <form class="flex gap-4 items-center">
                <div class="flex-1 max-w-sm">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           class="form-input"
                           placeholder="Buscar pedido...">
                </div>

                <select name="status" class="form-input max-w-[150px]">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                    <option value="em_producao" {{ request('status') == 'em_producao' ? 'selected' : '' }}>Em Produção</option>
                    <option value="concluido" {{ request('status') == 'concluido' ? 'selected' : '' }}>Concluídos</option>
                    <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                </select>

                <button type="submit" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
            </form>
        </div>

        <a href="{{ route('pedidos.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Pedido
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm">
        @if($pedidos->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Nenhum pedido encontrado</h3>
                <p class="text-gray-500 mb-4">Comece criando um novo pedido.</p>
                <a href="{{ route('pedidos.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Pedido
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Data Entrega</th>
                            <th>Valor Total</th>
                            <th>Lucro</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td class="font-medium text-gray-900">
                                    #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>{{ $pedido->cliente->nome }}</td>
                                <td>{{ $pedido->data_entrega->format('d/m/Y') }}</td>
                                <td>{{ $pedido->formatted_valor_total }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <span>{{ $pedido->formatted_lucro }}</span>
                                        <span class="text-sm text-gray-500">{{ $pedido->formatted_lucro_percentual }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($pedido->status === 'concluido')
                                        <span class="status-tag status-active">Concluído</span>
                                    @elseif($pedido->status === 'em_producao')
                                        <span class="status-tag status-pending">Em Produção</span>
                                    @elseif($pedido->status === 'pendente')
                                        <span class="status-tag status-pending">Pendente</span>
                                    @else
                                        <span class="status-tag status-inactive">Cancelado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('pedidos.show', $pedido) }}" 
                                           class="btn-icon"
                                           title="Visualizar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <a href="{{ route('pedidos.edit', $pedido) }}" 
                                           class="btn-icon"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('pedidos.destroy', $pedido) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este pedido?')">
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

            <!-- Pagination -->
            <div class="border-t border-gray-200">
                <div class="px-4 py-3">
                    {{ $pedidos->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 