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
       'valorCompra',
       'margem',
       'valorVenda',
       'codigo'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->codigo)) {
                $model->codigo = self::gerarCodigoUnico();
            }
        });
    }

    protected static function gerarCodigoUnico(): int
    {
        do {
            $codigo = random_int(100000, 999999);
        } while (self::where('codigo', $codigo)->exists());

        return $codigo;
    }

    public function getListProdutos(){
        return DB::table('produtos')
            ->select('produtos.*')
            ->get();
    }

    public function getProdutosBarcode($barcode) {
        return DB::table('produtos')
            ->select('produtos.*')
            ->whereNone(['produtos.produto', 'produtos.valorProduto'], $barcode)
            ->get();
    }
}
