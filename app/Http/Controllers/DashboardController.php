<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venda;

class DashboardController extends Controller
{
    public function dashboard(Venda $venda) {
        $valorEmVendaHoje = $venda->countValorEmVendaHoje();
        $valorVendasPorMes = $venda->valorVendasPorMes();
        return view('dashboard', ['valorEmVendaHoje' => $valorEmVendaHoje, 'valorVendasPorMes' => $valorVendasPorMes]);
    }
}
