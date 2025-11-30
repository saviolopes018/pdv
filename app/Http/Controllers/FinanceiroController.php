<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Financeiro;

class FinanceiroController extends Controller
{
    public function listagem() {
        $listLancamentos = Financeiro::get();
        return view('financeiro.listagem', ['listLancamentos' => $listLancamentos]);
    }

    public function registrar() {
        return view('financeiro.registrar');
    }

    public function salvar(Request $request) {
        $request->validate([
            'descricao' => 'required',
            'valorMovimentacao' => 'required',
            'dataMovimentacao' => 'required',
            'tipoMovimentacao' => 'required',
        ]);

        $path = null;

        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('uploads', 'public');
            $request->arquivo = $path;
        }

        $financeiro = Financeiro::create([
            'descricao' => $request->descricao,
            'valorMovimentacao' => $request->valorMovimentacao,
            'dataMovimentacao' => $request->dataMovimentacao,
            'tipoMovimentacao' => $request->tipoMovimentacao,
            'arquivo' => $path
        ]);

        if(!$financeiro) {
            return back()->with('error', 'Erro ao realizar lançamento!');
        }

        return redirect()->route('financeiro.listagem')->with('message-success', 'Lançamento realizado com sucesso!');
    }

    public function listagemContasPagar() {
        return view('financeiro.contas-pagar.listagem');
    }

    public function registrarContasPagar() {
        return view('financeiro.contas-pagar.registrar');
    }

    public function salvarContasPagar(Request $request) {
        $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
            'dataVencimento' => 'required',
        ]);

        $gastosFixos = GastosFixos::create([
            'descricao' => $request->descricao,
            'valor' => str_replace(['.', ','], ['', '.'], $request->valor),
            'dataVencimento' => $request->dataVencimento
        ]);

        if(!$gastosFixos) {
            return back()->with('error', 'Erro ao realizar registro de contas a pagar!');
        }

        return redirect()->route('financeiro.contas-pagar.listagem')->with('message-success', 'Contas a pagar registrada!');
    }

    public function listagemContasReceber() {
        return view('financeiro.contas-receber.listagem');
    }

    public function registrarContasReceber() {
        return view('financeiro.contas-receber.registrar');
    }

    public function salvarContasReceber(Request $request) {
    }
}
