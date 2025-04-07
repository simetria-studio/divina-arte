<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiasPrimas = MateriaPrima::query()
            ->when(request('search'), function($query, $search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('nome')
            ->paginate(10);

        return view('materia-prima.index', compact('materiasPrimas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materia-prima.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        // Converte valores monetários
        $input['custo_total'] = $this->converterParaFloat($input['custo_total']);
        
        // Calcula outros valores
        $input['custo_unitario'] = $input['custo_total'] / $input['quantidade'];
        $input['utilizacao'] = 1 / $input['rendimento'];
        $input['custo_utilizado'] = $input['custo_unitario'] * $input['utilizacao'];
        $input['estoque_minimo'] = 0;
        $input['estoque_maximo'] = $input['quantidade'] * 2;
        
        // Valida e cria
        $validated = $request->merge($input)->validate([
            'nome' => ['required', 'min:3'],
            'custo_total' => ['required', 'numeric', 'min:0'],
            'quantidade' => ['required', 'integer', 'min:1'],
            'rendimento' => ['required', 'integer', 'min:1'],
            'estoque_atual' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        $materiaPrima = MateriaPrima::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'materiaPrima' => $materiaPrima
            ]);
        }

        return redirect()
            ->route('materia-prima.index')
            ->with('success', 'Matéria prima cadastrada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MateriaPrima $materiaPrima)
    {
        return view('materia-prima.edit', compact('materiaPrima'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MateriaPrima $materiaPrima)
    {
        // Converte os valores monetários e porcentagem para o formato correto antes da validação
        $input = $request->all();
        
        // Converte valores monetários
        $input['custo_total'] = $this->converterParaFloat($input['custo_total']);
        $input['custo_unitario'] = $this->converterParaFloat($input['custo_unitario']);
        $input['custo_utilizado'] = $this->converterParaFloat($input['custo_utilizado']);
        
        // Converte porcentagem
        $input['rendimento'] = $this->converterParaFloat($input['rendimento']);

        // Validação
        $validated = $request->merge($input)->validate([
            'nome' => ['required', 'string', 'max:255'],
            'custo_total' => ['required', 'numeric', 'min:0'],
            'custo_unitario' => ['required', 'numeric', 'min:0'],
            'quantidade' => ['required', 'integer', 'min:0'],
            'rendimento' => ['required', 'numeric', 'min:0', 'max:100'],
            'utilizacao' => ['required', 'integer', 'min:0'],
            'custo_utilizado' => ['required', 'numeric', 'min:0'],
            'estoque_minimo' => ['required', 'integer', 'min:0'],
            'estoque_maximo' => ['required', 'integer', 'min:0', 'gt:estoque_minimo'],
            'estoque_atual' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        $materiaPrima->update($validated);

        return redirect()
            ->route('materia-prima.index')
            ->with('success', 'Matéria prima atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MateriaPrima $materiaPrima)
    {
        $materiaPrima->delete();

        return redirect()
            ->route('materia-prima.index')
            ->with('success', 'Matéria prima excluída com sucesso!');
    }

    /**
     * Converte um valor monetário ou porcentagem para float
     */
    private function converterParaFloat($valor)
    {
        // Remove R$ e %
        $valor = str_replace(['R$', '%'], '', $valor);
        
        // Remove pontos dos milhares e substitui vírgula por ponto
        return (float) str_replace(
            ['.', ','], 
            ['', '.'], 
            trim($valor)
        );
    }
}
