<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class FormaPagamento extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'forma_pagamento';

    protected $fillable = [
       'descricao'
    ];
}
