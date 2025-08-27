<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Venda extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'venda';

    protected $fillable = [
        'produto_id',
        'venda_pagamento_id',
        'quantidade',
        'valorUnidade',
        'valorTotal',
        'dataVenda'
    ];

    public function countValorEmVendaHoje() {
        $hoje = Carbon::now('America/Sao_Paulo');
        $dataFormatada = $hoje->format('Y-m-d');
        return DB::table('venda')
            ->select('venda.*')
            ->where('venda.dataVenda', $dataFormatada)
            ->sum('valorTotal');
    }

    public function valorVendasPorMes() {
        return DB::table('venda')
            ->select(DB::raw("DATE_FORMAT(dataVenda, '%m') as mes"), DB::raw('SUM(valorTotal) as valorTotalVendaMes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();
    }
}
