<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\FormaPagamento;
use App\Models\Venda;
use Carbon\Carbon;

class PDVController extends Controller
{
    public function index(Produto $produto, Request $request) {
        $cart  = $request->session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));
        $listFormasPagamento = FormaPagamento::get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'items' => array_values($cart),
                'total' => $total,
                'listFormasPagamento' => $listFormasPagamento
            ]);
        }

        // Requisição normal: retorna a view com as mesmas variáveis
        return view('pdv', [
            'items' => array_values($cart),
            'total' => $total,
            'listFormasPagamento' => $listFormasPagamento
        ]);
    }

    public function add(Request $request)
    {
        $id       = $request->input('id');
        $name     = $request->input('name');
        $price    = floatval($request->input('price'));
        $quantity = intval($request->input('quantity', 1));

        $cart = $request->session()->get('cart', []);

        // se já existir, só incrementa quantidade
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
            $cart[$id]['subtotal'] = $cart[$id]['quantity'] * $price;
        } else {
            $cart[$id] = [
                'id'       => $id,
                'name'     => $name,
                'price'    => $price,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity,
            ];
        }

        $request->session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'item'    => $cart[$id],
            'total'   => array_sum(array_column($cart, 'subtotal')),
        ]);
    }

    public function remove(Request $request)
    {
        $id   = $request->input('id');
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'total'   => array_sum(array_column($cart, 'subtotal')),
        ]);
    }

    public function clear(Request $request)
    {
        // Remove a chave 'cart' da sessão
        $request->session()->forget('cart');

        // Ou, alternativamente: $request->session()->put('cart', []);

        return response()->json([
            'success' => true,
            'total'   => 0,
        ]);
    }

    public function finalize(Request $request)
    {
        $cart = $request->session()->get('cart');
        foreach($cart as $c) {
            Venda::create([
                'produto_id' => $c['id'],
                'quantidade' => $c['quantity'],
                'forma_pagamento_id_primaria' => $request->all()['methods'][0],
                'valorPrimario' => $c['price'],
                'dataVenda' => new Carbon()
            ]);
        }
        // Remove a chave 'cart' da sessão
        $request->session()->forget('cart');

        // Ou, alternativamente: $request->session()->put('cart', []);

        return response()->json([
            'success' => true,
            'total'   => 0,
        ]);
    }
}
