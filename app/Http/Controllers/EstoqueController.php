<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        $movimentacoes = Estoque::query()
            ->with('materiaPrima')
            ->when(request('search'), function($query, $search) {
                $query->whereHas('materiaPrima', function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                });
            })
            ->when(request('tipo'), function($query, $tipo) {
                $query->where('tipo', $tipo);
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('estoque.index', compact('movimentacoes'));
    }

    public function create()
    {
        $materiasPrimas = MateriaPrima::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('estoque.create', compact('materiasPrimas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'materia_prima_id' => ['required', 'exists:materia_primas,id'],
            'quantidade' => ['required', 'integer', 'min:1'],
            'tipo' => ['required', 'in:entrada,saida'],
            'status' => ['required', 'in:pendente,concluido,cancelado'],
        ]);

        // Atualiza o estoque da matéria prima
        $materiaPrima = MateriaPrima::findOrFail($validated['materia_prima_id']);

        if ($validated['tipo'] === 'entrada') {
            $materiaPrima->estoque_atual += $validated['quantidade'];
        } else {
            if ($materiaPrima->estoque_atual < $validated['quantidade']) {
                return back()
                    ->withInput()
                    ->withErrors(['quantidade' => 'Quantidade insuficiente em estoque']);
            }
            $materiaPrima->estoque_atual -= $validated['quantidade'];
        }

        $materiaPrima->save();
        Estoque::create($validated);

        return redirect()
            ->route('estoque.index')
            ->with('success', 'Movimentação de estoque registrada com sucesso!');
    }

    public function destroy(Estoque $estoque)
    {
        // Reverte a movimentação no estoque
        $materiaPrima = $estoque->materiaPrima;

        if (!$materiaPrima) {
            $estoque->delete();
            return redirect()
                ->route('estoque.index')
                ->with('success', 'Movimentação de estoque excluída com sucesso!');
        }

        if ($estoque->tipo === 'entrada') {
            $materiaPrima->estoque_atual -= $estoque->quantidade;
        } else {
            $materiaPrima->estoque_atual += $estoque->quantidade;
        }

        $materiaPrima->save();
        $estoque->delete();

        return redirect()
            ->route('estoque.index')
            ->with('success', 'Movimentação de estoque excluída com sucesso!');
    }
}
