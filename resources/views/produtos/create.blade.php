@extends('layouts.dashboard')

@section('title', 'Novo Produto')
@section('header', 'Novo Produto')
@section('subheader', 'Cadastre um novo produto no sistema')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Informações do Produto</h2>
                    <p class="mt-1 text-sm text-gray-500">Preencha os dados do novo produto</p>
                </div>
                <a href="{{ route('produtos.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form action="{{ route('produtos.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="form-group md:col-span-2">
                    <label for="nome" class="form-label">Nome do Produto</label>
                    <input type="text" 
                           name="nome" 
                           id="nome" 
                           value="{{ old('nome') }}"
                           class="form-input @error('nome') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Digite o nome do produto">
                    @error('nome')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Matérias Primas -->
                <div class="form-group md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label">Matérias Primas do Produto</label>
                 
                    </div>

                    <!-- Seletor de Matéria Prima -->
                    <div class="flex gap-2 mb-4">
                        <div class="flex-1">
                            <select id="mp_selector" class="form-input">
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
                        </div>
                        <button type="button" 
                                onclick="adicionarMateriaPrima()"
                                class="btn-secondary px-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Lista de Matérias Primas Selecionadas -->
                    <div id="materias_primas_selecionadas" class="space-y-2">
                        <!-- Items serão adicionados aqui via JavaScript -->
                    </div>
                    
                    @error('materia_prima_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preço de Custo -->
                <div class="form-group">
                    <label for="preco_custo" class="form-label">Preço de Custo</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="preco_custo" 
                               id="preco_custo" 
                               value="{{ old('preco_custo') }}"
                               class="form-input pl-10 bg-gray-50 @error('preco_custo') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00"
                               readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Calculado automaticamente com base nas matérias primas</p>
                    @error('preco_custo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preço de Venda -->
                <div class="form-group">
                    <label for="preco_venda" class="form-label">Preço de Venda</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" 
                               name="preco_venda" 
                               id="preco_venda" 
                               value="{{ old('preco_venda') }}"
                               class="form-input pl-10 @error('preco_venda') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00">
                    </div>
                    @error('preco_venda')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Margem (Calculada automaticamente) -->
                <div class="form-group">
                    <label for="margem" class="form-label">Margem</label>
                    <div class="relative">
                        <input type="text" 
                               name="margem" 
                               id="margem" 
                               value="{{ old('margem') }}"
                               class="form-input pr-8 bg-gray-50 @error('margem') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="0,00"
                               readonly>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Calculada automaticamente com base no preço de custo e venda</p>
                    @error('margem')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Horas de Trabalho -->
                <div class="form-group">
                    <label for="horas_trabalho" class="form-label">Horas de Trabalho</label>
                    <input type="number" 
                           name="horas_trabalho" 
                           id="horas_trabalho" 
                           value="{{ old('horas_trabalho') }}"
                           min="0"
                           step="0.5"
                           class="form-input @error('horas_trabalho') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="0">
                    @error('horas_trabalho')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" 
                            id="status" 
                            class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3 border-t border-gray-100 pt-6">
                <a href="{{ route('produtos.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Cadastrar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Matéria Prima -->
<div id="modal-materia-prima" 
     class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Nova Matéria Prima</h3>
                <button type="button" 
                        onclick="fecharModalMateriaPrima()"
                        class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="form-materia-prima" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="form-group md:col-span-2">
                    <label for="mp_nome" class="form-label">Nome</label>
                    <input type="text" id="mp_nome" class="form-input" required>
                </div>

                <!-- Custo Total -->
                <div class="form-group">
                    <label for="mp_custo_total" class="form-label">Custo Total</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="text" id="mp_custo_total" class="form-input pl-10" required>
                    </div>
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="mp_quantidade" class="form-label">Quantidade</label>
                    <input type="number" id="mp_quantidade" class="form-input" min="1" required>
                </div>

                <!-- Rendimento -->
                <div class="form-group">
                    <label for="mp_rendimento" class="form-label">Rendimento (unidades)</label>
                    <input type="number" id="mp_rendimento" class="form-input" min="1" required>
                </div>

                <!-- Estoque Atual -->
                <div class="form-group">
                    <label for="mp_estoque_atual" class="form-label">Estoque Atual</label>
                    <input type="number" id="mp_estoque_atual" class="form-input" min="0" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t border-gray-200 pt-6">
                <button type="button" 
                        onclick="fecharModalMateriaPrima()" 
                        class="btn-secondary">
                    Cancelar
                </button>
                <button type="submit" class="btn-primary">
                    Salvar Matéria Prima
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o Select2 no seletor de matéria prima
    $('#mp_selector').select2({
        placeholder: 'Buscar matéria prima...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Nenhuma matéria prima encontrada";
            }
        },
        templateResult: formatMateriaPrima,
        templateSelection: formatMateriaPrima
    });

    // Máscaras para valores monetários (remover preço de venda daqui)
    const camposMonetarios = ['preco_venda'];
    
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
            }).on('complete', function() {
                calcularMargem(); // Calcula margem quando o valor estiver completo
            });
        }
    });

    // Cálculo da margem
    function calcularMargem() {
        console.log('Calculando Margem');
        const precoCustoInput = document.getElementById('preco_custo');
        const precoVendaInput = document.getElementById('preco_venda');
        const margemInput = document.getElementById('margem');

        // Converte os valores monetários para números
        const precoCusto = parseFloat(precoCustoInput.value.replace('R$', '').replace(/\./g, '').replace(',', '.').trim()) || 0;
        const precoVenda = parseFloat(precoVendaInput.value.replace('R$', '').replace(/\./g, '').replace(',', '.').trim()) || 0;
        
        console.log('Calculando Margem:', { precoCusto, precoVenda });

        if (precoCusto > 0 && precoVenda > 0) {
            // Calcula a margem: ((Preço Venda - Preço Custo) / Preço Custo) * 100
            const margem = ((precoVenda - precoCusto) / precoCusto) * 100;
            
            console.log('Margem calculada:', margem);
            
            // Formata com 2 casas decimais e adiciona o símbolo %
            margemInput.value = margem.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + '%';
        } else {
            margemInput.value = '0,00%';
        }
    }

    // Adiciona os listeners para calcular a margem
    const precoCustoInput = document.getElementById('preco_custo');
    const precoVendaInput = document.getElementById('preco_venda');

    if (precoVendaInput) {
        precoVendaInput.addEventListener('change', calcularMargem);
    }
    if (precoCustoInput) {
        precoCustoInput.addEventListener('change', calcularMargem);
    }

    // Calcula inicial se já houver valores
    if (precoCustoInput.value || precoVendaInput.value) {
        calcularMargem();
    }
});

// Funções do Modal
function abrirModalMateriaPrima() {
    document.getElementById('modal-materia-prima').classList.remove('hidden');
}

function fecharModalMateriaPrima() {
    document.getElementById('modal-materia-prima').classList.add('hidden');
    document.getElementById('form-materia-prima').reset();
}

// Função para adicionar matéria prima à lista
function adicionarMateriaPrima() {
    const select = document.getElementById('mp_selector');
    const option = select.options[select.selectedIndex];
    
    if (!option || !option.value) {
        alert('Selecione uma matéria prima');
        return;
    }

    const id = option.value;
    const nome = option.dataset.nome;
    const custo = parseFloat(option.dataset.custo);
    const estoque = parseInt(option.dataset.estoque);

    // Verifica se já foi adicionada
    if (document.querySelector(`input[name="materia_prima_id[]"][value="${id}"]`)) {
        alert('Esta matéria prima já foi adicionada');
        return;
    }

    // Atualiza o preço de custo
    const precoCustoInput = document.getElementById('preco_custo');
    let custoAtual = 0;
    
    // Se já existe um valor, converte ele corretamente
    if (precoCustoInput.value) {
        custoAtual = parseFloat(precoCustoInput.value.replace('R$', '').replace(/\./g, '').replace(',', '.').trim());
    }
    
    // Soma o novo custo
    const novoCusto = custoAtual + custo;

    // Formata e atualiza o input
    precoCustoInput.value = novoCusto.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    // Dispara o evento de input para recalcular a margem
    precoCustoInput.dispatchEvent(new Event('input'));

    // Cria o elemento da matéria prima
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
    div.innerHTML = `
        <div>
            <p class="font-medium text-gray-900">${nome}</p>
            <p class="text-sm text-gray-500">
                Custo: R$ ${custo.toLocaleString('pt-BR', {minimumFractionDigits: 2})} | 
                Estoque: <span class="${estoque > 0 ? 'text-green-600' : 'text-red-600'}">${estoque}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" 
                    onclick="removerMateriaPrima(this)" 
                    class="text-red-600 hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            <input type="hidden" name="materia_prima_id[]" value="${id}">
        </div>
    `;

    document.getElementById('materias_primas_selecionadas').appendChild(div);
    select.value = '';
    $(select).trigger('change');
}

// Função para remover matéria prima da lista
function removerMateriaPrima(button) {
    button.closest('div.flex.items-center.justify-between').remove();
    recalcularCustoTotal();
}

// Função para recalcular o custo total
function recalcularCustoTotal() {
    let custoTotal = 0;
    const container = document.getElementById('materias_primas_selecionadas');
    
    container.querySelectorAll('input[name="materia_prima_id[]"]').forEach(input => {
        const id = input.value;
        const option = document.querySelector(`#mp_selector option[value="${id}"]`);
        const custoUtilizado = parseFloat(option.dataset.custo) || 0;
        
        custoTotal += custoUtilizado; // Quantidade fixa em 1
    });

    // Atualiza o campo de preço de custo
    const precoCustoInput = document.getElementById('preco_custo');
    const custoFormatado = custoTotal.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    
    // Atualiza o valor do input
    precoCustoInput.value = custoFormatado;

    // Dispara o evento de input para recalcular a margem
    precoCustoInput.dispatchEvent(new Event('input'));
}

// Função para formatar a exibição das matérias primas
function formatMateriaPrima(materiaPrima) {
    if (!materiaPrima.id) return materiaPrima.text;
    
    const $materiaPrima = $(materiaPrima.element);
    const estoque = $materiaPrima.data('estoque');
    const custo = $materiaPrima.data('custo');
    
    return $(`
        <div class="flex items-center justify-between">
            <div>
                <strong>${materiaPrima.text.split('(')[0]}</strong>
                <div class="text-sm text-gray-500">
                    Custo: R$ ${custo.toLocaleString('pt-BR', {minimumFractionDigits: 2})}
                </div>
            </div>
            <div class="text-sm ${estoque > 0 ? 'text-green-600' : 'text-red-600'}">
                Estoque: ${estoque}
            </div>
        </div>
    `);
}
</script>
@endpush
@endsection 