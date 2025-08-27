@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Estoque</h2>
        </div>
        <div class="col-md-12 bottom-pull-right">
            <div class="d-flex justify-content-end">
                <a href="{{ route('estoque.listagem') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp;
                    Voltar</a>
            </div>
        </div>
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Os seguintes campos são obrigatórios.</h4>
                    <p style="color:#000">
                        @foreach ($errors->all() as $key => $error)
                            {{ $error }}@if (array_key_last($errors->all()) == $key)
                            . @else,
                            @endif
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
                    <p class="p-span-required">Os campos que estão com <span class="span-required">*</span> são
                        obrigatórios.</p>
                </div>
                <div class="card-body card-block">
                    <form id="stepperForm" method="POST" action="{{ route('estoque.salvar') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="descricao" class="form-control-label">Produto <span
                                            class="span-required">*</span></label>
                                    <select id="normalize" style="margin-top: 5%;" name="produto_id">
                                        <option value=""></option>
                                        @foreach($listProdutos as $produto)
                                        <option value="{{ $produto->id }}">{{ $produto->produto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantidade" class="form-control-label">Quantidade <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="quantidade" name="quantidade"
                                        class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dataMovimentacao" class="form-control-label">Data da Movimentação <span
                                            class="span-required">*</span></label>
                                    <input type="date" id="dataMovimentacao" name="dataMovimentacao" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipoMovimentacao" class="form-control-label">Tipo de Movimentação <span
                                            class="span-required">*</span></label>
                                    <select name="tipoMovimentacao" id="tipoMovimentacao" class="form-control">
                                        <option value="0">Selecione</option>
                                        <option value="1">Entrada</option>
                                        <option value="2">Saída</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row pull-right">
                            <div class="col-md-12 d-flex justify-content-end" style="gap:5px;">
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
    </div>
@endsection
@push('styles')
    <style>
        /* Wrapper geral */
        .selectize-control {
            position: relative;
            display: block;
            width: 100%;
            font-family: var(--bs-body-font-family, Arial, sans-serif);
            font-size: 1rem;
        }

        /* Área de input */
        .selectize-input {
            display: flex;
            align-items: center;
            width: 100%;
            min-height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-shadow: none;
        }

        /* Hover & focus */
        .selectize-input:focus,
        .selectize-input.input-active {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Dropdown */
        .selectize-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
            font-size: 1rem;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
        }

        /* Itens da lista */
        .selectize-dropdown .option {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
        }

        .selectize-dropdown .option:hover,
        .selectize-dropdown .active {
            color: #fff;
            background-color: #0d6efd;
            /* Azul padrão Bootstrap */
        }

        /* Itens selecionados (multi) */
        .selectize-control.multi .selectize-input>div {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            margin-right: 0.25rem;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 0.2rem;
            font-size: 0.875rem;
        }

        /* Botão de remover (multi) */
        .selectize-control.plugin-remove_button .item .remove {
            padding: 0 0.25rem;
            margin-left: 0.25rem;
            color: #fff;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 0.2rem;
            cursor: pointer;
        }

        .selectize-control.plugin-remove_button .item .remove:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Desabilitado */
        .selectize-input.disabled {
            background-color: #e9ecef;
            opacity: 1;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectize/dist/css/selectize.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#normalize').selectize();
    </script>
@endpush
