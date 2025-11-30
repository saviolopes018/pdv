@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Financeiro</h2>
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end bottom-pull-right">
                <a href="{{ route('financeiro.registrar') }}" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;
                    Registrar</a>
            </div>
        </div>
        <div class="col-md-12">
            @if (session('message-success'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Sucesso</span>
                    {{ session('message-success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table id="bootstrap-data-table-export" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Tipo de Movimentação</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listLancamentos as $lancamento)
                                <tr>
                                    <td>{{ $lancamento->descricao }}</td>
                                    <td>R$ {{ number_format((float) str_replace(['.', ','], ['', '.'], $lancamento->valorMovimentacao), 2, ',', '.') }}</td>
                                    <td>
                                    @if($lancamento->tipoMovimentacao == 1)
                                    <span class="badge badge-success">Entrada</span>
                                    @else
                                    <span class="badge badge-danger">Saída</span>
                                    @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($lancamento->dataMoviemntacao)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($lancamento->arquivo)
                                            <a class="btn btn-warning btn-sm btn-icon-actions" href="{{ Storage::url($lancamento->arquivo) }}" target="_blank" title="Ver Arquivo"><i class="fa fa-magnifying-glass"></i></a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
