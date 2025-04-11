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

        $input['pedido_id'] = $pedido->id;

        // Cria o item
        Item::create($input);

        // Atualiza o valor total do pedido
        $pedido->valor_total = $pedido->itens()->sum('valor_total');
        $pedido->save();

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Item adicionado com sucesso!');
    }

    public function edit(Pedido $pedido, Item $item)
    {

        $itens = Item::where('pedido_id', $pedido->id)->get();
        $produtos = Produto::where('status', 'ativo')
            ->orderBy('nome')
            ->get();

        return view('itens.edit', compact('pedido', 'itens', 'produtos'));
    }

    public function update(Request $request, Pedido $pedido, Item $item)
    {
        // dd($request->all());
        $input = $request->all();

        // Converte valores monetários
        $input['custo_unitario'] = $this->converterParaFloat($input['custo_unitario']);
        $input['desconto'] = $this->converterParaFloat($input['desconto']);
        $input['valor_total'] = $this->converterParaFloat($input['valor_total']);

        $item->update($input);

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
        // Remove R$, % e qualquer tipo de espaço (incluindo \u{A0})
        $valor = preg_replace('/[R$%\s]/u', '', $valor);

        // Substitui vírgula por ponto e remove pontos de milhar
        return (float) str_replace(
            ['.', ','],
            ['', '.'],
            trim($valor)
        );
    }
}
