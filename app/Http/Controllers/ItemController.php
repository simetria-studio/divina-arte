<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create(Pedido $pedido)
    {
        $produtos = Produto::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('itens.create', compact('pedido', 'produtos'));
    }

    public function store(Request $request, Pedido $pedido)
    {
        $input = $request->all();
        
        // Converte valores monetários
        $input['custo_unitario'] = $this->converterParaFloat($input['custo_unitario']);
        $input['desconto'] = $this->converterParaFloat($input['desconto']);
        $input['valor_total'] = $this->converterParaFloat($input['valor_total']);

        $validated = $request->merge($input)->validate([
            'produto_id' => ['required', 'exists:produtos,id'],
            'quantidade' => ['required', 'integer', 'min:1'],
            'custo_unitario' => ['required', 'numeric', 'min:0'],
            'desconto' => ['required', 'numeric', 'min:0'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:pendente,concluido,cancelado'],
        ]);

        $validated['pedido_id'] = $pedido->id;
        
        // Cria o item
        Item::create($validated);

        // Atualiza o valor total do pedido
        $pedido->valor_total = $pedido->itens()->sum('valor_total');
        $pedido->save();

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Item adicionado com sucesso!');
    }

    public function edit(Pedido $pedido, Item $item)
    {
        $produtos = Produto::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('itens.edit', compact('pedido', 'item', 'produtos'));
    }

    public function update(Request $request, Pedido $pedido, Item $item)
    {
        $input = $request->all();
        
        // Converte valores monetários
        $input['custo_unitario'] = $this->converterParaFloat($input['custo_unitario']);
        $input['desconto'] = $this->converterParaFloat($input['desconto']);
        $input['valor_total'] = $this->converterParaFloat($input['valor_total']);

        $validated = $request->merge($input)->validate([
            'produto_id' => ['required', 'exists:produtos,id'],
            'quantidade' => ['required', 'integer', 'min:1'],
            'custo_unitario' => ['required', 'numeric', 'min:0'],
            'desconto' => ['required', 'numeric', 'min:0'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:pendente,concluido,cancelado'],
        ]);

        // Atualiza o item
        $item->update($validated);

        // Atualiza o valor total do pedido
        $pedido->valor_total = $pedido->itens()->sum('valor_total');
        $pedido->save();

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido, Item $item)
    {
        $item->delete();

        // Atualiza o valor total do pedido
        $pedido->valor_total = $pedido->itens()->sum('valor_total');
        $pedido->save();

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Item removido com sucesso!');
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