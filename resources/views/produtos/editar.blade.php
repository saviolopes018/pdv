@extends('components.app')

@section('content')
    <div class="content animated fadeIn">
        <div class="col-md-12 mt-3">
            <h2 class="pb-2 display-5">Produtos</h2>
        </div>
        <div class="col-md-12 bottom-pull-right">
            <div class="d-flex justify-content-end">
                <a href="{{ route('produto.listagem') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp;
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
                    <form id="stepperForm" method="POST" action="{{ route('produto.atualizar', $produto->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="produto" class="form-control-label">Produto <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="produto" name="produto" class="form-control"
                                        autocomplete="off" value="{{ $produto->produto }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valorCompra" class="form-control-label">Valor de Compra (R$) <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="valorCompra" name="valorCompra" class="form-control"
                                        autocomplete="off" value="{{ number_format($produto->valorCompra, 2, ',', '.') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="margem" class="form-control-label">Margem (%) <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="margem" name="margem" class="form-control"
                                        autocomplete="off" value="{{ $produto->margem }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valorVenda" class="form-control-label">Valor de Venda (R$) <span
                                            class="span-required">*</span></label>
                                    <input type="text" id="valorVenda" name="valorVenda" class="form-control"
                                        autocomplete="off" readonly value="{{ number_format($produto->valorVenda, 2, ',', '.') }}">
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
@push('scripts')
    <script>
        document.getElementById('valorCompra').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            e.target.value = value;
        });

        $('#margem').on('keyup', function() {
            const margem = $(this).val() || 0;
            console.log(margem)
            const valor = parseBrNumber($("#valorCompra").val()) || 0;
            console.log(valor)
            const total = (valor * margem) / 100 + valor;
            console.log(total)

            $("#valorVenda").val(formatBrNumber(total));
        });

        $('#valorCompra').on('keyup', function() {
            const margem = $("#margem").val() || 0;
            if(margem != 0) {
                const valor = parseBrNumber($("#valorCompra").val()) || 0;
                const total = (valor * margem) / 100 + valor;
                $("#valorVenda").val(formatBrNumber(total));
            }
        });

        function parseBrNumber(value) {
            if (!value) return 0;

             value = value.toString().trim();

            if (value.includes(',')) {
                value = value.replace(/\./g, '').replace(',', '.');
            }

            const number = parseFloat(value);
            return isNaN(number) ? 0 : number;
        }

        function formatBrNumber(value) {
            return value.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    </script>
@endpush
