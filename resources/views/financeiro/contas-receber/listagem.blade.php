@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Contas a receber</h2>
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end bottom-pull-right">
                <a href="{{ route('financeiro.contas-receber.registrar') }}" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
