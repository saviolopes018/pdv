<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\FormaPagamento;
use App\Models\Venda;
use App\Models\VendaPagamento;
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
        $request->session()->forget('cart');

        return response()->json([
            'success' => true,
            'total'   => 0,
        ]);
    }

    public function finalize(Request $request)
    {
        $cart = $request->session()->get('cart');
        $splitPayment = filter_var($request->all()['splitPayment'], FILTER_VALIDATE_BOOLEAN);
        $vendaPagamento;
        if($splitPayment){
            $vendaPagamento = VendaPagamento::create([
                'forma_pagamento_id_primaria' => $request->all()['methods'][0],
                'valor_venda_primaria' => $request->all()['amounts'][0],
                'pagamentoDividido' => $request->all()['splitPayment'],
                'forma_pagamento_id_secundaria' => $request->all()['methods'][1],
                'valor_venda_secundaria' => $request->all()['amounts'][1],
                'pagamentoDividido' => $splitPayment
            ]);
         }else {
            $vendaPagamento = VendaPagamento::create([
                'forma_pagamento_id_primaria' => $request->all()['methods'][0],
                'valor_venda_primaria' => $request->all()['amounts'][0],
                'pagamentoDividido' => $splitPayment
            ]);
        }
        foreach($cart as $c) {
            $venda = Venda::create([
                'produto_id' => $c['id'],
                'venda_pagamento_id' => $vendaPagamento->id,
                'quantidade' => $c['quantity'],
                'valorUnidade' => $c['price'],
                'valorTotal' => $c['subtotal'],
                'dataVenda' => new Carbon()
            ]);

        }

        $request->session()->forget('cart');

        return response()->json([
            'success' => true,
            'total'   => 0,
        ]);
    }
}
