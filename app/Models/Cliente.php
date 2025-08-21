<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'clientes';

    protected $fillable = [
        'primeiroNome',
        'sobrenome',
        'dataNascimento',
        'cpf',
        'email',
        'telefone',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cnpj',
        'razaoSocial',
        'nomeFantasia',
        'status'
    ];

    public function listClientes() {
        return DB::table('clientes')
            ->select('id', 'primeiroNome', 'sobrenome', 'telefone', 'cpf', 'status')
            ->get();
    }
}
