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
        $listCategorias = Categoria::get();
        return view('produtos.adicionar', ['listCategorias' => $listCategorias]);
    }

    public function editar(Request $request){
        $produto = Produto::find($request->idProduto);
        $listCategorias = Categoria::get();
        return view('produtos.editar', ['produto'=> $produto, 'listCategorias' => $listCategorias]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'produto' => 'required',
            'valorProduto' => 'required',
            'categoria_id' => 'required',
        ]);

        $path = null;

        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('uploads', 'public');
            $request->arquivo = $path;
        }

        $produto = Produto::create([
            'produto' => $request->produto,
            'valorProduto' => $request->valorProduto,
            'categoria_id' => $request->categoria_id,
            'arquivo' => $path
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
            'categoria_id' => 'required',
        ]);

        $produto = Produto::find($idProduto);

        $path;

        if ($request->hasFile('arquivo')) {
            if ($produto->arquivo) {
                Storage::disk('public')->delete($produto->arquivo);
            }
            $path = $request->file('arquivo')->store('uploads', 'public');
            $request->arquivo = $path;
        }else {
           $path =  $produto->arquivo;
        }

        $produto->update([
            'produto' => $request->produto,
            'valorProduto' => $request->valorProduto,
            'categoria_id' => $request->categoria_id,
            'arquivo' => $path
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

        $produtos = Produto::where('barCode', $term)
        ->orWhere('produto', 'like', "%{$term}%")
        ->get();

        return response()->json($produtos);

    }
}
