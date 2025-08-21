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
        'quantidade',
        'valorTotal',
        'forma_pagamento_id_primaria',
        'valorPrimario',
        'pagamentoDividido',
        'forma_pagamento_id_secundaria',
        'valorSecundario',
        'dataVenda'
    ];

    public function countValorEmVendaHoje() {
        $hoje = Carbon::now();
        $dataFormatada = $hoje->format('Y-m-d');
        return DB::table('venda')
            ->select('venda.*')
            ->where('venda.dataVenda', $dataFormatada)
            ->sum('valorPrimario');
    }

    public function valorVendasPorMes() {
        return DB::table('venda')
            ->select(DB::raw("DATE_FORMAT(dataVenda, '%m') as mes"), DB::raw('SUM(valorPrimario) as valorTotalVendaMes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();
    }
}
