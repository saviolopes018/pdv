<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function listagem() {
        $categorias = Categoria::get();
        return view('categoria.listagem', ['categorias' => $categorias]);
    }

    public function adicionar() {
        return view('categoria.adicionar');
    }

    public function editar(Request $request) {
        $categoria = Categoria::find($request->idCategoria);
        return view('categoria.editar', ['categoria' => $categoria]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'descricao' => 'required'
        ]);

        $categoria = Categoria::create($request->all());

        if(!$categoria) {
            return back()->with('error', 'Erro ao realizar cadastro da categoria!');
        }

        return redirect()->route('categoria.listagem')->with('message-success', 'Categoria cadastrada!');
    }

    public function atualizar(Request $request, $idProduto) {
        $request->validate([
            'descricao' => 'required'
        ]);

        $categoria = Categoria::find($idProduto);

        $categoria->update($request->all());

        if(!$categoria) {
            return back()->with('error', 'Erro ao atualizar produto!');
        }

        return redirect()->route('categoria.listagem')->with('message-success', 'Categoria atualizada!');
    }
}
