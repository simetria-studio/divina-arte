@extends('layouts.dashboard')

@section('title', 'Produtos')
@section('header', 'Produtos')
@section('subheader', 'Gerencie os produtos do sistema')

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
                           placeholder="Buscar produto...">
                </div>

                <select name="status" class="form-input max-w-[150px]">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                    <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativos</option>
                </select>

                <button type="submit" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
            </form>
        </div>

        <a href="{{ route('produtos.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Produto
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
        @if($produtos->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Nenhum produto encontrado</h3>
                <p class="text-gray-500 mb-4">Comece cadastrando um novo produto no sistema.</p>
                <a href="{{ route('produtos.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Produto
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Matéria Prima</th>
                            <th>Preço Custo</th>
                            <th>Preço Venda</th>
                            <th>Margem</th>
                            <th>Horas</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $produto->nome }}</td>
                                <td>{{ $produto->materiasPrimas->first() ? $produto->materiasPrimas->first()->nome : 'N/A' }}</td>
                                <td>{{ $produto->formatted_preco_custo }}</td>
                                <td>{{ $produto->formatted_preco_venda }}</td>
                                <td>{{ $produto->formatted_margem }}</td>
                                <td>{{ $produto->horas_trabalho }}</td>
                                <td>
                                    @if($produto->status === 'ativo')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Ativo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inativo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('produtos.edit', $produto) }}" 
                                           class="btn-icon"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('produtos.destroy', $produto) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
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
                    {{ $produtos->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 