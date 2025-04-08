<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::query()
            ->with('materiasPrimas')
            ->when(request('search'), function($query, $search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('nome')
            ->paginate(10);

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $materiasPrimas = MateriaPrima::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('produtos.create', compact('materiasPrimas'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // Converte valores monetários
        $input['preco_custo'] = $this->converterParaFloat($input['preco_custo']);
        $input['preco_venda'] = $this->converterParaFloat($input['preco_venda']);
        $input['margem'] = $this->converterParaFloat($input['margem']);

        // Valida os dados
        $validated = $request->merge($input)->validate([
            'nome' => ['required', 'min:3'],
            'preco_custo' => ['required', 'numeric'],
            'preco_venda' => ['required', 'numeric'],
            'margem' => ['required', 'numeric'],
            'materia_prima_id' => ['required', 'array'],
            'materia_prima_id.*' => ['exists:materia_primas,id'],
            'horas_trabalho' => ['required', 'numeric'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        // Remove materia_prima_id do array validated pois será usado na relação
        $materiasPrimasIds = $validated['materia_prima_id'];
        unset($validated['materia_prima_id']);

        // Cria o produto
        $produto = Produto::create($validated);

        // Anexa as matérias primas
        $produto->materiasPrimas()->attach($materiasPrimasIds);

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Produto $produto)
    {
        $produto->load('materiasPrimas');
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $materiasPrimas = MateriaPrima::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('produtos.edit', compact('produto', 'materiasPrimas'));
    }

    public function update(Request $request, Produto $produto)
    {
        $input = $request->all();

        // Converte valores monetários antes da validação
        $input['preco_venda'] = $this->converterParaFloat($input['preco_venda']);
        $input['margem'] = $this->converterParaFloat($input['margem']);

        // Valida todos os campos de uma vez
        $validated = $request->merge($input)->validate([
            'nome' => ['required', 'string', 'max:255'],
            'materia_prima_id' => ['required', 'array'],
            'materia_prima_id.*' => ['exists:materia_primas,id'],
            'preco_venda' => ['required', 'numeric'],
            'margem' => ['required', 'numeric'],
            'horas_trabalho' => ['required', 'numeric'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        // Calcula o preço de custo baseado nas matérias primas selecionadas
        $precoCusto = 0;
        $materiasPrimas = MateriaPrima::whereIn('id', $validated['materia_prima_id'])->get();
        foreach ($materiasPrimas as $materiaPrima) {
            $precoCusto += $materiaPrima->custo_utilizado;
        }

        // Remove materia_prima_id do array validated pois será usado na relação
        $materiasPrimasIds = $validated['materia_prima_id'];
        unset($validated['materia_prima_id']);

        // Adiciona o preço de custo calculado
        $validated['preco_custo'] = $precoCusto;

        // Atualiza o produto
        $produto->update($validated);

        // Sincroniza as matérias primas
        $produto->materiasPrimas()->sync($materiasPrimasIds);

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }

    private function converterParaFloat($valor)
    {
        $valor = str_replace(['R$', '%'], '', $valor);
        return (float) str_replace(
            ['.', ','],
            ['', '.'],
            trim($valor)
        );
    }
}
