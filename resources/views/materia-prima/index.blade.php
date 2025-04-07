@extends('layouts.dashboard')

@section('title', 'Matérias Primas')
@section('header', 'Matérias Primas')
@section('subheader', 'Gerencie as matérias primas do sistema')

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

        <a href="{{ route('materia-prima.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Matéria Prima
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
        @if($materiasPrimas->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Nenhuma matéria prima encontrada</h3>
                <p class="text-gray-500 mb-4">Comece cadastrando uma nova matéria prima no sistema.</p>
                <a href="{{ route('materia-prima.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Matéria Prima
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Custo Total</th>
                            <th>Custo Unitário</th>
                            <th>Quantidade</th>
                            <th>Rendimento</th>
                            <th>Estoque Atual</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiasPrimas as $materiaPrima)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $materiaPrima->nome }}</td>
                                <td>{{ $materiaPrima->formatted_custo_total }}</td>
                                <td>{{ $materiaPrima->formatted_custo_unitario }}</td>
                                <td>{{ $materiaPrima->quantidade }}</td>
                                <td>{{ $materiaPrima->formatted_rendimento }}</td>
                                <td>
                                    <div class="flex items-center">
                                        @if($materiaPrima->estoque_atual <= $materiaPrima->estoque_minimo)
                                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                        @elseif($materiaPrima->estoque_atual >= $materiaPrima->estoque_maximo)
                                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                        @endif
                                        {{ $materiaPrima->estoque_atual }}
                                    </div>
                                </td>
                                <td>
                                    @if($materiaPrima->status === 'ativo')
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
                                        <a href="{{ route('materia-prima.edit', $materiaPrima) }}" 
                                           class="btn-icon"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('materia-prima.destroy', $materiaPrima) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta matéria prima?')">
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
                    {{ $materiasPrimas->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 