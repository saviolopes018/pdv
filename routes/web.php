<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\EnviarEmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDVController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstoqueController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/hash', [AuthController::class, 'hash'])->name('hash');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/home', [HomeController::class, 'home'])->name('home');

    //PDV
    Route::get('/pdv', [PDVController::class, 'index'])->name('pdv');
    Route::get('/produto/buscar/pdv', [ProdutoController::class, 'buscarPdv'])->name('produto.buscar.pdv');

    Route::post('/cart/add', [PDVController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove',[PDVController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [PDVController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/finalize', [PDVController::class, 'finalize'])->name('cart.finalize');

    //Clientes
    Route::get('/clientes/listagem', [ClienteController::class, 'listagem'])->name('clientes.listagem');
    Route::get('/clientes/cadastro', [ClienteController::class, 'cadastro'])->name('clientes.cadastro');
    Route::get('/clientes/editar/{idCliente}', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::get('/clientes/inativar/{idCliente}', [ClienteController::class, 'inativar'])->name('clientes.inativar');
    Route::get('/clientes/ativar/{idCliente}', [ClienteController::class, 'ativar'])->name('clientes.ativar');
    Route::post('/clientes/inserir', [ClienteController::class, 'salvar'])->name('clientes.inserir');
    Route::put('/clientes/atualizar/{idCliente}', [ClienteController::class, 'atualizar'])->name('clientes.atualizar');

    //Categorias
    Route::get('/categoria/listagem', [CategoriaController::class, 'listagem'])->name('categoria.listagem');
    Route::get('/categoria/adicionar', [CategoriaController::class, 'adicionar'])->name('categoria.adicionar');
    Route::get('/categoria/editar/{idCategoria}', [CategoriaController::class, 'editar'])->name('categoria.editar');
    Route::post('/categoria/salvar', [CategoriaController::class, 'salvar'])->name('categoria.salvar');
    Route::put('/categoria/atualizar/{id}', [CategoriaController::class, 'atualizar'])->name('categoria.atualizar');

    //Financeiro
    Route::get('/financeiro/listagem', [FinanceiroController::class, 'listagem'])->name('financeiro.listagem');
    Route::get('/financeiro/registrar', [FinanceiroController::class, 'registrar'])->name('financeiro.registrar');
    Route::post('/financeiro/salvar', [FinanceiroController::class, 'salvar'])->name('financeiro.salvar');

    Route::get('/email', [EnviarEmailController::class, 'view'])->name('email');
    Route::post('/email/enviar', [EnviarEmailController::class, 'enviar'])->name('email.enviar');

    //Produtos
    Route::get('/produto/listagem', [ProdutoController::class, 'listagem'])->name('produto.listagem');
    Route::get('/produto/adicionar', [ProdutoController::class, 'adicionar'])->name('produto.adicionar');
    Route::get('/produto/editar/{idProduto}', [ProdutoController::class, 'editar'])->name('produto.editar');
    Route::post('/produto/salvar', [ProdutoController::class, 'salvar'])->name('produto.salvar');
    Route::put('/produto/atualizar/{id}', [ProdutoController::class, 'atualizar'])->name('produto.atualizar');

    // Usuário
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //Estoque
    Route::get('/estoque/listagem', [EstoqueController::class, 'listagem'])->name('estoque.listagem');
    Route::get('/estoque/registrar', [EstoqueController::class, 'registrar'])->name('estoque.registrar');
    Route::post('/estoque/salvar', [EstoqueController::class, 'salvar'])->name('estoque.salvar');

});
