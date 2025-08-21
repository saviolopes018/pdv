<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoRecebido;

class EnviarEmailController extends Controller
{

    public function view() {
        return view('teste');
    }

    public function enviar(Request $request){
        $dados = $request->only(['nome', 'email', 'mensagem']);

        Mail::to('savio.lopes@b8lab.com.br')->send(new ContatoRecebido($dados));

        return response()->json(['mensagem' => 'Email enviado com sucesso']);
    }
}
