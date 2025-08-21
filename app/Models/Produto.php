<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'produtos';

    protected $fillable = [
       'produto',
       'valorProduto',
       'categoria_id',
       'barCode',
       'arquivo'
    ];

    public function getListProdutos(){
        return DB::table('produtos')
            ->join('categoria', 'produtos.categoria_id','=','categoria.id')
            ->select('produtos.*', 'categoria.descricao as descricaoCategoria')
            ->get();
    }

    public function getProdutosBarcode($barcode) {
        return DB::table('produtos')
            ->join('categoria', 'produtos.categoria_id','=','categoria.id')
            ->select('produtos.*', 'categoria.descricao as descricaoCategoria')
            ->whereNone(['produtos.barCode', 'produtos.produto', 'produtos.valorProduto'], $barcode)
            ->get();
    }
}
