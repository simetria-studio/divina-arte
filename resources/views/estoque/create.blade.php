@extends('layouts.dashboard')

@section('title', 'Nova Movimentação')
@section('header', 'Nova Movimentação')
@section('subheader', 'Registre uma nova movimentação de estoque')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Dados da Movimentação</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados da movimentação de estoque</p>
                </div>
                <a href="{{ route('estoque.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('estoque.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Matéria Prima -->
                <div class="form-group md:col-span-2">
                    <label for="materia_prima_id" class="form-label">Matéria Prima</label>
                    <select name="materia_prima_id" 
                            id="materia_prima_id" 
                            class="form-input @error('materia_prima_id') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="">Selecione uma matéria prima</option>
                        @foreach($materiasPrimas as $materiaPrima)
                            <option value="{{ $materiaPrima->id }}" 
                                    {{ old('materia_prima_id') == $materiaPrima->id ? 'selected' : '' }}>
                                {{ $materiaPrima->nome }} (Atual: {{ $materiaPrima->estoque_atual }})
                            </option>
                        @endforeach
                    </select>
                    @error('materia_prima_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" 
                           name="quantidade" 
                           id="quantidade" 
                           value="{{ old('quantidade') }}"
                           min="1"
                           step="1"
                           class="form-input @error('quantidade') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('quantidade')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div class="form-group">
                    <label for="tipo" class="form-label">Tipo de Movimentação</label>
                    <select name="tipo" 
                            id="tipo" 
                            class="form-input @error('tipo') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ old('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                    @error('tipo')
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
                <a href="{{ route('estoque.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Registrar Movimentação
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 