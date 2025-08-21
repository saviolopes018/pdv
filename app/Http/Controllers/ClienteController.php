<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function listagem(Cliente $cliente) {
        $clientes = $cliente->listClientes();
        return view('clientes.listagem', ['clientes' => $clientes]);
    }

    public function cadastro() {
        return view('clientes.cadastro');
    }

    public function editar(Request $request) {
        $cliente = Cliente::find($request->idCliente);
        return view('clientes.editar', ['cliente' => $cliente]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'primeiroNome' => 'required',
            'sobrenome' => 'required',
            'dataNascimento' => 'required',
            'cpf' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        $cliente = Cliente::create($request->all());

        if(!$cliente) {
                return back()->with('error', 'Erro ao realizar cadastro do cliente!');
        }

        return redirect()->route('clientes.listagem')->with('message-success', 'Cliente cadastrado!');

    }

    public function atualizar(Request $request, $idCliente) {
        $request->validate([
            'primeiroNome' => 'required',
            'sobrenome' => 'required',
            'dataNascimento' => 'required',
            'cpf' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        $cliente = Cliente::find($idCliente);

        $cliente->update($request->all());

        if(!$cliente) {
                return back()->with('error', 'Erro ao atualizar cliente!');
        }

        return redirect()->route('clientes.listagem')->with('message-success', 'Cliente atualizado!');
    }

    public function inativar(Request $request) {
        $cliente = Cliente::find($request->idCliente);

        $cliente->update([
            'status' => 0
        ]);

        return redirect()->route('clientes.listagem')->with('message-success', 'Cliente inativado com sucesso!');
    }

    public function ativar(Request $request) {
        $cliente = Cliente::find($request->idCliente);

        $cliente->update([
            'status' => 1
        ]);

        return redirect()->route('clientes.listagem')->with('message-success', 'Cliente ativado com sucesso!');
    }
}
