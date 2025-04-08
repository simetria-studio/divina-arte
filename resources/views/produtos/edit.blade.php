@extends('layouts.dashboard')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Editar Produto</h1>
        <p class="mt-1 text-sm text-gray-600">Edite as informações do produto</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-medium text-gray-900">Informações do Produto</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados do produto</p>
                </div>
                <a href="{{ route('produtos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    VOLTAR
                </a>
            </div>

            <form action="{{ route('produtos.update', $produto) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Nome -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Produto</label>
                        <input type="text"
                               name="nome"
                               id="nome"
                               value="{{ old('nome', $produto->nome) }}"
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Digite o nome do produto">
                    </div>

                    <!-- Matérias Primas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Matérias Primas do Produto</label>

                        <!-- Seletor de Matéria Prima -->
                        <div class="flex gap-2 mt-1">
                            <select id="mp_selector" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Buscar matéria prima...</option>
                                @foreach($materiasPrimas->where('status', 'ativo') as $materiaPrima)
                                    <option value="{{ $materiaPrima->id }}"
                                            data-nome="{{ $materiaPrima->nome }}"
                                            data-custo="{{ $materiaPrima->custo_utilizado }}"
                                            data-estoque="{{ $materiaPrima->estoque_atual }}">
                                        {{ $materiaPrima->nome }}
                                        (Custo: {{ $materiaPrima->formatted_custo_utilizado }} | Estoque: {{ $materiaPrima->estoque_atual }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button"
                                    onclick="adicionarMateriaPrima()"
                                    class="flex-shrink-0 p-2 text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Lista de Matérias Primas Selecionadas -->
                        <div id="materias_primas_selecionadas" class="mt-3 space-y-2">
                            @foreach($produto->materiasPrimas as $materiaPrima)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <input type="hidden" name="materia_prima_id[]" value="{{ $materiaPrima->id }}">
                                        <p class="font-medium">{{ $materiaPrima->nome }}</p>
                                        <p class="text-sm text-gray-500">Custo: {{ $materiaPrima->formatted_custo_utilizado }} | Estoque: {{ $materiaPrima->estoque_atual }}</p>
                                    </div>
                                    <button type="button"
                                            onclick="removerMateriaPrima(this)"
                                            class="text-gray-400 hover:text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Preço de Custo -->
                        <div>
                            <label for="preco_custo" class="block text-sm font-medium text-gray-700">Preço de Custo</label>
                            <div class="relative mt-1">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">R$</span>
                                </div>
                                <input type="text"
                                       name="preco_custo"
                                       id="preco_custo"
                                       value="{{ old('preco_custo', $produto->preco_custo) }}"
                                       class="block pr-12 pl-7 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="0,00"
                                       readonly>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Calculado automaticamente com base nas matérias primas</p>
                        </div>

                        <!-- Preço de Venda -->
                        <div>
                            <label for="preco_venda" class="block text-sm font-medium text-gray-700">Preço de Venda</label>
                            <div class="relative mt-1">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">R$</span>
                                </div>
                                <input type="text"
                                       name="preco_venda"
                                       id="preco_venda"
                                       value="{{ old('preco_venda', $produto->preco_venda) }}"
                                       class="block pr-12 pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="0,00">
                            </div>
                        </div>

                        <!-- Margem -->
                        <div>
                            <label for="margem" class="block text-sm font-medium text-gray-700">Margem</label>
                            <div class="relative mt-1">
                                <input type="text"
                                       name="margem"
                                       id="margem"
                                       value="{{ old('margem', $produto->margem) }}"
                                       class="block pr-8 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="0,00"
                                       readonly>
                                <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Calculada automaticamente com base no preço de custo e venda</p>
                        </div>

                        <!-- Horas de Trabalho -->
                        <div>
                            <label for="horas_trabalho" class="block text-sm font-medium text-gray-700">Horas de Trabalho</label>
                            <input type="number"
                                   name="horas_trabalho"
                                   id="horas_trabalho"
                                   value="{{ old('horas_trabalho', $produto->horas_trabalho) }}"
                                   min="0"
                                   step="0.5"
                                   class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="0">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                    id="status"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="ativo" {{ old('status', $produto->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ old('status', $produto->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 mt-6 space-x-3 border-t">
                    <button type="button" onclick="window.history.back()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
                        CANCELAR
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md border border-transparent hover:bg-indigo-700">
                        ATUALIZAR PRODUTO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Função para adicionar matéria prima à lista
    function adicionarMateriaPrima() {
        const select = document.getElementById('mp_selector');
        const selectedOption = select.options[select.selectedIndex];

        if (!selectedOption.value) return;

        const container = document.getElementById('materias_primas_selecionadas');
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
        div.innerHTML = `
            <div class="flex-1">
                <input type="hidden" name="materia_prima_id[]" value="${selectedOption.value}">
                <p class="font-medium">${selectedOption.dataset.nome}</p>
                <p class="text-sm text-gray-500">Custo: R$ ${parseFloat(selectedOption.dataset.custo).toFixed(2)} | Estoque: ${selectedOption.dataset.estoque}</p>
            </div>
            <button type="button"
                    onclick="removerMateriaPrima(this)"
                    class="text-gray-400 hover:text-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        container.appendChild(div);
        select.selectedIndex = 0;
        calcularPrecoCusto();
    }

    // Função para remover matéria prima da lista
    function removerMateriaPrima(button) {
        button.parentElement.remove();
        calcularPrecoCusto();
    }

    // Função para calcular o preço de custo
    function calcularPrecoCusto() {
        const materiasPrimas = document.querySelectorAll('#materias_primas_selecionadas input[name="materia_prima_id[]"]');
        let total = 0;

        materiasPrimas.forEach(input => {
            const option = document.querySelector(`#mp_selector option[value="${input.value}"]`);
            if (option) {
                total += parseFloat(option.dataset.custo);
            }
        });

        document.getElementById('preco_custo').value = total.toFixed(2);
        calcularMargem();
    }

    // Função para calcular a margem
    function calcularMargem() {
        const precoCusto = parseFloat(document.getElementById('preco_custo').value) || 0;
        const precoVenda = parseFloat(document.getElementById('preco_venda').value) || 0;

        if (precoCusto > 0) {
            const margem = ((precoVenda - precoCusto) / precoCusto) * 100;
            document.getElementById('margem').value = margem.toFixed(2);
        }
    }

    // Event listeners
    document.getElementById('preco_venda').addEventListener('input', calcularMargem);
    document.addEventListener('DOMContentLoaded', function() {
        calcularPrecoCusto();
    });
</script>
@endpush
