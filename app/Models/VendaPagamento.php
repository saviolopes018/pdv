<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class VendaPagamento extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'venda_pagamento';

    protected $fillable = [
        'venda_id',
        'forma_pagamento_id_primaria',
        'valor_venda_primaria',
        'pagamentoDividido',
        'forma_pagamento_id_secundaria',
        'valor_venda_secundaria',
    ];
}
