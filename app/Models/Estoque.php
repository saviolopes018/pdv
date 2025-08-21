<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Estoque extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'estoque';

    protected $fillable = [
        'produto_id',
        'quantidade',
        'dataMovimentacao',
        'tipoMovimentacao',
    ];

    public function getEstoque() {
        return DB::table('estoque')
            ->join('produtos', 'produtos.id','=','estoque.produto_id')
            ->select('estoque.*', 'produtos.produto as descricaoProduto')
            ->get();
    }
}
