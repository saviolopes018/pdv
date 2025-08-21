<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Financeiro extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'financeiro';

    protected $fillable = [
        'descricao',
        'valorMovimentacao',
        'dataMovimentacao',
        'tipoMovimentacao',
        'arquivo',
    ];
}
