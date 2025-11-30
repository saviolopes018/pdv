@extends('components.app')

@section('content')
    <div class="col-md-12">
        <h2 class="pb-2 display-5">Contas a receber</h2>
    </div>
    <div class="col-md-12" style="margin-bottom: 10px;">
        <div class="d-flex justify-content-end">
            <a href="{{ route('financeiro.contas-receber.listagem') }}" class="btn btn-secondary"><i
                    class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
        </div>
    </div>
    <div class="col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Os seguintes campos são obrigatórios.</h4>
                <p style="color:#000">
                    @foreach ($errors->all() as $key => $error)
                    {{ $error }}@if(array_key_last($errors->all()) == $key). @else, @endif
                    @endforeach
                </p>
                <hr>
                <p class="mb-0" style="color:#000">Preencha e tente novamente!</p>
            </div>
        @endif
        @if (session('error'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Erro</span>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <strong class="card-title">#</strong>
            </div>
            <div class="card-body card-block">
                <form id="stepperForm" method="POST" action="{{ route('financeiro.contas-receber.salvar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descricao" class="form-control-label">Descrição <span
                                                class="span-required">*</span></label>
                                <input type="text" id="descricao" name="descricao" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valor" class="form-control-label">Valor<span
                                                class="span-required">*</span></label>
                                <input type="text" id="valor" name="valor" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dataVencimento" class="form-control-label">Data de Vencimento<span
                                                class="span-required">*</span></label>
                                <input type="date" id="dataVencimento" name="dataVencimento" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row pull-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-md m-l-10 m-b-10">
                                <i class="fa fa-send"></i> Salvar
                            </button>
                            <button type="reset" class="btn btn-warning btn-md m-l-10 m-b-10">
                                <i class="fa fa-trash"></i> Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.getElementById('valor').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            e.target.value = value;
        });
    </script>
@endpush
