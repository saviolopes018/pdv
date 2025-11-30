<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function listagem(Produto $produto) {
        $listProdutos = $produto->getListProdutos();
        return view('produtos.listagem', ['listProdutos' => $listProdutos]);
    }

    public function adicionar() {
        return view('produtos.adicionar');
    }

    public function editar(Request $request){
        $produto = Produto::find($request->idProduto);
        $listCategorias = Categoria::get();
        return view('produtos.editar', ['produto'=> $produto, 'listCategorias' => $listCategorias]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'produto' => 'required',
            'valorCompra' => 'required',
            'margem' => 'required',
            'valorVenda' => 'required',
        ]);

        $produto = Produto::create([
            'produto' => $request->produto,
            'valorCompra' => str_replace(['.', ','], ['', '.'],$request->valorCompra),
            'margem' => $request->margem,
            'valorVenda' => str_replace(['.', ','], ['', '.'],$request->valorVenda),
        ]);

        if(!$produto) {
            return back()->with('error', 'Erro ao adicionar produto!');
        }

        return redirect()->route('produto.listagem')->with('message-success', 'Produto adicionado.');
    }

    public function atualizar(Request $request, $idProduto) {
        $request->validate([
            'produto' => 'required',
            'valorProduto' => 'required',
        ]);

        $produto = Produto::find($idProduto);

        $produto->update([
            'produto' => $request->produto,
            'valorCompra' => str_replace(['.', ','], ['', '.'],$request->valorCompra),
            'margem' => $request->margem,
            'valorVenda' => str_replace(['.', ','], ['', '.'],$request->valorVenda),
        ]);

        if(!$produto) {
            return back()->with('error', 'Erro ao atualizar produto!');
        }

        return redirect()->route('produto.listagem')->with('message-success', 'Produto atualizado!');
    }

    public function buscarPdv(Request $request, Produto $produto) {
        // $barcode = $request->query('barcode');
        // $produto = $produto->getProdutosBarcode($barcode);

        // return $produto;
        $term = $request->query('search');

        $produtos = Produto::where('codigo', $term)
        ->orWhere('produto', 'like', "%{$term}%")
        ->get();

        return response()->json($produtos);

    }
}
