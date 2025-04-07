<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::query()
            ->with(['cliente', 'itens.produto'])
            ->when(request('search'), function($query, $search) {
                $query->whereHas('cliente', function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::where('status', 'ativo')->orderBy('nome')->get();
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'data_entrega' => ['required', 'date', 'after:today'],
            'status' => ['required', 'in:pendente,em_producao,concluido,cancelado'],
            'itens' => ['required', 'array', 'min:1'],
            'itens.*.produto_id' => ['required', 'exists:produtos,id'],
            'itens.*.quantidade' => ['required', 'integer', 'min:1'],
            'itens.*.custo_unitario' => ['required'],
            'itens.*.desconto' => ['required'],
            'itens.*.valor_total' => ['required'],
        ]);

        // Inicia a transação
        DB::beginTransaction();
        try {
            // Cria o pedido
            $pedido = Pedido::create([
                'cliente_id' => $validated['cliente_id'],
                'data_entrega' => $validated['data_entrega'],
                'status' => $validated['status'],
                'custo_total' => 0,
                'valor_total' => 0,
                'lucro' => 0,
                'lucro_percentual' => 0,
            ]);

            // Processa os itens
            $custoTotal = 0;
            $valorTotalPedido = 0;

            foreach ($validated['itens'] as $item) {
                // Converte valores monetários
                $custoUnitario = $this->converterParaFloat($item['custo_unitario']);
                $desconto = $this->converterParaFloat($item['desconto']);
                $valorTotalItem = $this->converterParaFloat($item['valor_total']);

                // Calcula o custo total do item
                $custoItemTotal = $custoUnitario * $item['quantidade'];
                $custoTotal += $custoItemTotal;

                // Cria o item
                $pedido->itens()->create([
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'custo_unitario' => $custoUnitario,
                    'desconto' => $desconto,
                    'valor_total' => $valorTotalItem,
                ]);

                // Acumula o valor total do pedido
                $valorTotalPedido += $valorTotalItem;
            }

            // Atualiza os totais do pedido
            $lucro = $valorTotalPedido - $custoTotal;
            $lucroPercentual = $custoTotal > 0 ? ($lucro / $custoTotal) * 100 : 0;

            $pedido->update([
                'custo_total' => $custoTotal,
                'valor_total' => $valorTotalPedido,
                'lucro' => $lucro,
                'lucro_percentual' => $lucroPercentual,
            ]);

            DB::commit();

            return redirect()
                ->route('pedidos.show', $pedido)
                ->with('success', 'Pedido criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao criar pedido: ' . $e->getMessage()]);
        }
    }

    /**
     * Converte um valor monetário para float
     */
    private function converterParaFloat($valor)
    {
        if (is_numeric($valor)) return $valor;
        
        $valor = str_replace(['R$', '%'], '', $valor);
        return (float) str_replace(
            ['.', ','], 
            ['', '.'], 
            trim($valor)
        );
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'itens.produto']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'data_entrega' => ['required', 'date', 'after:today'],
            'status' => ['required', 'in:pendente,em_producao,concluido,cancelado'],
        ]);

        $pedido->update($validated);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->itens()->delete();
        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido excluído com sucesso!');
    }
}
