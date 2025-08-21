<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Estoque;

class EstoqueController extends Controller
{
    public function listagem(Estoque $estoque) {
        $listEstoque = $estoque->getEstoque();
        return view('estoque.listagem', ['listEstoque' => $listEstoque]);
    }

    public function registrar(Produto $produto) {
        $listProdutos = $produto->getListProdutos();
        return view('estoque.registrar', ['listProdutos' => $listProdutos]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'produto_id' => 'required',
            'quantidade' => 'required',
            'dataMovimentacao' => 'required',
            'tipoMovimentacao' => 'required'
        ]);

        $estoque = Estoque::create($request->all());

        if(!$estoque) {
            return back()->with('error', 'Erro ao lançamento no estoque!');
        }

        return redirect()->route('estoque.listagem')->with('message-success', 'Estoque atualizado com sucesso!');
    }
}
