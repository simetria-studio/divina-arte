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
    Route::resource('pedidos.itens', ItemController::class)->except(['index', 'show']);
    Route::resource('pedidos', PedidoController::class);

});
