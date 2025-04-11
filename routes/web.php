<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MateriaPrimaController;


Route::get('/', function () {
    return view('home');
})->name('home');

//criar rota para o painel com middleware de autenticação
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('clientes', ClienteController::class);
    Route::resource('materia-prima', MateriaPrimaController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('estoque', EstoqueController::class)->except(['edit', 'update', 'show']);

    // Rotas manuais para itens
    Route::get('/pedidos/{pedido}/itens/create', [ItemController::class, 'create'])->name('pedidos.itens.create');
    Route::post('/pedidos/{pedido}/itens', [ItemController::class, 'store'])->name('pedidos.itens.store');
    Route::get('/pedidos/{pedido}/itens/{item}/edit', [ItemController::class, 'edit'])->name('pedidos.itens.edit');
    Route::put('/pedidos/{pedido}/itens/{item}', [ItemController::class, 'update'])->name('pedidos.itens.update');
    Route::delete('/pedidos/{pedido}/itens/{item}', [ItemController::class, 'destroy'])->name('pedidos.itens.destroy');

    // Rotas manuais para pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/pedidos/{pedido}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

});
