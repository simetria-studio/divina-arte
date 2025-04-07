@extends('layouts.dashboard')

@section('title', 'Controle de Estoque')
@section('header', 'Controle de Estoque')
@section('subheader', 'Gerencie as movimentações de estoque')

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
                           placeholder="Buscar matéria prima...">
                </div>

                <select name="tipo" class="form-input max-w-[150px]">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entradas</option>
                    <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saídas</option>
                </select>

                <select name="status" class="form-input max-w-[150px]">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
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

        <a href="{{ route('estoque.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Movimentação
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
        @if($movimentacoes->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Nenhuma movimentação encontrada</h3>
                <p class="text-gray-500 mb-4">Comece registrando uma nova movimentação de estoque.</p>
                <a href="{{ route('estoque.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Movimentação
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Matéria Prima</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Status</th>
                            <th width="100">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimentacoes as $movimentacao)
                            <tr>
                                <td>{{ $movimentacao->created_at->format('d/m/Y H:i') }}</td>
                                <td class="font-medium text-gray-900">
                                    {{ $movimentacao->materiaPrima->nome ?? 'N/A' }}
                                </td>
                                <td>
                                    @if($movimentacao->tipo === 'entrada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Entrada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Saída
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $movimentacao->quantidade }}</td>
                                <td>
                                    @if($movimentacao->status === 'concluido')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Concluído
                                        </span>
                                    @elseif($movimentacao->status === 'pendente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pendente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Cancelado
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('estoque.destroy', $movimentacao) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta movimentação?')">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200">
                <div class="px-4 py-3">
                    {{ $movimentacoes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 