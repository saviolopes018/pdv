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
}
