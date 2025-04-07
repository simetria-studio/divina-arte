@extends('layouts.dashboard')

@section('title', 'Gestão de Clientes')
@section('header', 'Gestão de Clientes')
@section('subheader', 'Gerencie todos os seus clientes em um só lugar')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total de Clientes -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center">
                <span class="p-2 bg-indigo-50 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total de Clientes</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">{{ $clientes->total() }}</p>
                        <span class="ml-2 text-sm text-green-600">+12%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Novos Clientes -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center">
                <span class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Novos Clientes</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">0</p>
                        <span class="ml-2 text-sm text-gray-500">este mês</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pedidos Ativos -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center">
                <span class="p-2 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </span>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pedidos Ativos</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">28</p>
                        <span class="ml-2 text-sm text-yellow-600">Pendentes</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receita Total -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center">
                <span class="p-2 bg-purple-50 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Receita Total</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">R$ 45.850</p>
                        <span class="ml-2 text-sm text-green-600">+8%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Clientes -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Lista de Clientes</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $clientes->total() }} clientes cadastrados</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-2">
                        <select class="filter-select">
                            <option>Todos os Status</option>
                            <option>Ativos</option>
                            <option>Inativos</option>
                        </select>
                        <select class="filter-select">
                            <option>Ordenar por</option>
                            <option>Nome</option>
                            <option>Data de Cadastro</option>
                        </select>
                    </div>
                    
                    <div class="relative">
                        <input type="text" placeholder="Buscar clientes..." class="search-input">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <a href="{{ route('clientes.create') }}" class="btn-primary inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Novo Cliente
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contato
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Localização
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cadastro
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Ações</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">
                                                {{ strtoupper(substr($cliente->nome, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $cliente->nome }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: #{{ str_pad($cliente->id, 5, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cliente->email }}</div>
                                <div class="text-sm text-gray-500">{{ $cliente->telefone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cliente->cidade }}/{{ $cliente->estado }}</div>
                                <div class="text-sm text-gray-500">{{ $cliente->cep }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-tag status-active">
                                    Ativo
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">{{ $cliente->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $cliente->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="text-gray-400 hover:text-gray-900">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg class="w-8 h-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Nenhum cliente cadastrado</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comece cadastrando seu primeiro cliente.</p>
                                    <a href="{{ route('clientes.create') }}" class="mt-4 btn-primary">
                                        Cadastrar Cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $clientes->links() }}
        </div>
    </div>
</div>
@endsection 