@extends('components.app-pdv')

@section('title', 'PDV')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <input type="text" class="form-control" placeholder="Buscar produto..." id="buscarProduto" autofocus
                autocomplete="off">
        </div>
        <div class="row g-4">
            <div class="col-md-8 col-lg-9">
                <section class="pdv-products row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div class="col-lg-12">
                        <div class="alert alert-warning text-center mb-0 alert-sem-produtos" role="alert">
                            Produto não encontrado!
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="alert alert-success text-center mb-0 alert-venda-finalizada" role="alert">
                            Venda finalizada com sucesso!
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Carrinho <i class="fa fa-cart-shopping"></i></h5>
                        <div class="pdv-cart-items mb-3"></div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total:</span>
                            <span id="pdvTotal">R$ 0,00</span>
                        </div>
                        <div class="d-grid gap-2 d-md-flex">
                            <button class="btn btn-primary me-2" id="btnPagamento">Pagamento <i
                                    class="fa-solid fa-money-bill-1-wave"></i></button>
                            <button class="btn btn-warning btn-cancelar" id="btnCancelar">Esvaziar <i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <a href="https://b8lab.com.br/" style="text-decoration: none; color: darkgrey" target="_blank">Desenvolvido com 💜 pela B8 Lab</a>
        </footer>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Resumo da Venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="cart-preview mb-3"></div>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <span id="paymentModalTotal">R$ 0,00</span>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="splitPayment">
                        <label class="form-check-label" for="splitPayment">
                            Desejar usar duas formas de pagamento?
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Forma de Pagamento</label>
                        <select id="paymentMethod" class="form-select">
                            <option value="0">Selecione</option>
                            @foreach ($listFormasPagamento as $forma)
                                <option value="{{ $forma->id }}">{{ $forma->descricao }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="secondPaymentContainer">
                        <label for="paymentMethod2" class="form-label">Segunda Forma de Pagamento</label>
                        <select id="paymentMethod2" class="form-select">
                            <option value="0">Selecione</option>
                            @foreach ($listFormasPagamento as $forma)
                                <option value="{{ $forma->id }}">{{ $forma->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3 d-none" id="splitValuesContainer">
                        <div class="col-md-6">
                            <label for="paymentAmount1" class="form-label">Valor da Primeira Forma de Pagamento</label>
                            <input type="text" id="paymentAmount1" class="form-control" inputmode="decimal">
                        </div>
                        <div class="col-md-6">
                            <label for="paymentAmount2" class="form-label">Valor da Segunda Forma de Pagamento</label>
                            <input type="text" id="paymentAmount2" class="form-control" disabled placeholder="0.00"
                                inputmode="decimal">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar <i
                                class="fa fa-close"></i></button>
                        <button type="button" class="btn btn-success" id="btnFinalizeSale">Finalizar <i
                                class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
    @endpush

    @push('scripts')
        <script defer>
            let total = 0;

            function updateCartUI({
                item,
                total
            }) {
                // Exemplo: adiciona item na lista de itens
                const list = document.querySelector('.pdv-cart-items');
                // Se já existir linha para este item, atualize quantidade/subtotal
                let row = list.querySelector(`[data-id="${item.id}"]`);
                if (!row) {
                    row = document.createElement('div');
                    row.className = 'cart-item d-flex justify-content-between';
                    row.setAttribute('data-id', item.id);
                    row.innerHTML = `
                        <span>${item.name} × ${item.quantity}</span>
                        <span>R$ ${item.subtotal.toFixed(2).replace('.', ',')}</span>
                        `;
                    list.append(row);
                } else {
                    row.innerHTML = `
                        <span>${item.name} × ${item.quantity}</span>
                        <span>R$ ${item.subtotal.toFixed(2).replace('.', ',')}</span>
                        `;
                }

                // Atualiza total
                document.querySelector('#pdvTotal').textContent =
                    'R$ ' + total.toFixed(2).replace('.', ',');
            }

            document.addEventListener('DOMContentLoaded', () => {
                loadCart();
                const input = document.getElementById('buscarProduto');
                $('.alert-sem-produtos').hide();
                $('.alert-venda-finalizada').hide();

                // Quando o scanner “digitar” e emular ENTER:
                input.addEventListener('keyup', e => {
                    $('.alert-venda-finalizada').hide();
                    $('.alert-sem-produtos').hide();
                    if (e.key === 'Enter') {
                        const search = input.value.trim();
                        if (search) {
                            buscarProduto(search);
                        } else {
                            $('.pdv-products.row .pdv-product[name="produtos"]').closest('.col').remove();
                        }
                    }else if(e.key === 'Backspace'){
                        $('.pdv-products.row .pdv-product[name="produtos"]').closest('.col').remove();
                    }
                });

                function showAlert(msg, type = 'info') {
                    const $a = $(`
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${msg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                    // insere no topo do container
                    $('.container').prepend($a);
                    setTimeout(() => $a.alert('close'), 5000);
                }

                function buscarProduto(search) {
                    $.ajax({
                        url: "{{ route('produto.buscar.pdv') }}",
                        method: 'GET',
                        data: {
                            search: search
                        },
                        dataType: 'json',
                        success: function(data) {
                            loadCart();
                            $('.alert-sem-produtos').hide();

                            if (data.length === 0) {
                                // só adiciona UMA vez
                                if (data.length === 0) {

                                    $('.alert-sem-produtos').show();
                                }
                                return;
                            }

                            $.each(data, function(i, produto) {
                                if ($('.pdv-product[data-id="' + produto.id + '"]').length === 0) {

                                    const $col = $('<div>').addClass('col');

                                    // Cria o card com as classes e atributos
                                    const $card = $('<div>')
                                        .addClass('card shadow-sm text-center pdv-product h-100')
                                        .attr('data-name', produto.produto)
                                        .attr('data-price', produto.valorProduto)
                                        .attr('data-id', produto.id)
                                        .attr('name', 'produtos');

                                    // Cria o card-body
                                    const $cardBody = $('<div>').addClass('card-body');

                                    // Título e texto do preço já formatado em R$
                                    const $title = $('<h6>')
                                        .addClass('card-title')
                                        .text(produto.produto);

                                    const priceText = 'R$ ' +
                                        parseFloat(produto.valorProduto)
                                        .toFixed(2)
                                        .replace('.', ',');

                                    const $price = $('<p>')
                                        .addClass('card-text')
                                        .text(priceText);

                                    // Monta tudo junto
                                    $cardBody.append($title, $price);
                                    $card.append($cardBody);
                                    $col.append($card);

                                    $('.pdv-products.row').append($col);

                                    $card.on('click', function() {
                                        $.ajax({
                                            url: '/cart/add',
                                            method: 'POST',
                                            data: {
                                                id: produto.id,
                                                name: produto.produto,
                                                price: produto.valorProduto,
                                                quantity: 1,
                                                _token: "{{ csrf_token() }}"
                                            },
                                            success: function(json) {
                                                if (json.success) {
                                                    updateCartUI(json);
                                                }
                                            }
                                        });
                                    });
                                }
                            });
                        },
                        error: function(xhr, status) {
                            if (status !== 'abort') console.error('Erro na busca');
                        }
                    });
                }

                function updateCartUI({
                    item,
                    total
                }) {
                    const $list = $('.pdv-cart-items');

                    let $linha = $list.find(`[data-id="${item.id}"]`);
                    if (!$linha.length) {
                        $linha = $('<div>')
                            .addClass('cart-item d-flex justify-content-between align-items-center')
                            .attr('data-id', item.id);
                        $list.append($linha);
                    }

                    // Monta o HTML mostrando nome × quantidade e subtotal
                    $linha.html(`
                    <div>
                                <strong>${item.name}</strong>
                                <span class="text-muted">× ${item.quantity}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                <span class="me-3">R$ ${item.subtotal.toFixed(2).replace('.', ',')}</span>
                                <button class="btn btn-sm btn-danger btn-remove-item" data-id="${item.id}">&times;</button>
                            </div>
                `);
                    // Atualiza o total geral
                    $('#pdvTotal').text('R$ ' + total.toFixed(2).replace('.', ','));
                }
            });

            function loadCart() {
                $.get('/pdv', function(json) {
                    const $list = $('.pdv-cart-items').empty(); // limpa HTML antigo

                    // Renderiza cada item a partir do JSON
                    json.items.forEach(item => {
                        const $linha = $('<div>')
                            .addClass('cart-item d-flex justify-content-between align-items-center')
                            .attr('data-id', item.id)
                            .html(`
                            <div>
                                <strong>${item.name}</strong>
                                <span class="text-muted">× ${item.quantity}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                <span class="me-3">R$ ${item.subtotal.toFixed(2).replace('.', ',')}</span>
                                <button class="btn btn-sm btn-danger btn-remove-item" data-id="${item.id}">&times;</button>
                            </div>
                            `);

                        $list.append($linha);
                    });

                    // Atualiza total
                    $('#pdvTotal').text('R$ ' + json.total.toFixed(2).replace('.', ','));
                });

                $('.pdv-cart-items').on('click', '.btn-remove-item', function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: '/cart/remove',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(json) {
                            if (json.success) {
                                loadCart(json);
                            }
                        }
                    });
                });

                $('.btn-cancelar').on('click', function() {
                    $.ajax({
                        url: '/cart/clear',
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(json) {
                            if (json.success) {
                                loadCart(json);
                            }
                        }
                    });
                });

                const paymentModal = new bootstrap.Modal($('#paymentModal')[0]);

                $('#btnPagamento').on('click', function() {
                    const $itens = $('.pdv-cart-items .cart-item');
                    if (!$itens.length) {
                        return showAlert('Selecione ao menos um produto antes de pagar!', 'warning');
                    } else {
                        // Monta preview dentro do modal
                        const $preview = $('#paymentModal .cart-preview').empty();
                        const $table = $(`
                    <table class="table table-sm tableListProdutos">
                    <thead>
                        <tr><th>Produto</th><th>Quantidade</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                `);
                        let total = 0;

                        $itens.each(function() {
                            const $row = $(this);
                            const name = $row.find('strong').text();
                            const qtyMatch = $row.find('.text-muted').text().match(/×\s*(\d+)/);
                            const qty = qtyMatch ? parseInt(qtyMatch[1], 10) : 1;
                            const subtotal = parseFloat(
                                $row.find('span').eq(1).text().replace(/[R$\s.]/g, '').replace(',', '.')
                            );
                            total += subtotal;

                            $table.find('tbody').append(`
                    <tr>
                        <td>${name}</td>
                        <td>${qty}</td>
                        <td>R$ ${subtotal.toFixed(2).replace('.', ',')}</td>
                    </tr>
                    `);
                        });

                        $preview.append($table);
                        $('#paymentModalTotal').text('R$ ' + total.toFixed(2).replace('.', ','));

                        // Abre o modal
                        paymentModal.show();
                    }
                });

                // 4) Finalizar venda: lê os valores e métodos
                $('#btnFinalizeSale').on('click', function() {
                    if (!$('.pdv-cart-items .cart-item').length) {
                        return showAlert('Selecione ao menos um produto antes de pagar!', 'warning');
                    }

                    const method1 = $('#paymentMethod').val();
                    const amount1 = parseFloat($('#paymentAmount1').val()) || parseFloat(
                        $('#paymentModalTotal').text()
                        .replace(/[R$\s]/g, '')
                        .replace(',', '.')
                    ) || 0;

                    let methods = [method1],
                        amounts = [amount1],
                        splitPayment = false;

                    if ($('#splitPayment').is(':checked')) {
                        splitPayment = true;
                        methods = [];
                        amounts = [];

                        const method1 = $('#paymentMethod').val();
                        const amount1 = parseFloat(
                            $('#paymentAmount1').val()
                            .replace(/[R$\s]/g, '')
                            .replace(',', '.')
                        ) || 0;

                        const method2 = $('#paymentMethod2').val();
                        const amount2 = parseFloat($('#paymentAmount2').val()
                            .replace(/[R$\s]/g, '')
                            .replace(',', '.')
                        ) || 0;

                        methods.push(method1, method2);
                        amounts.push(amount1, amount2);
                    }

                    const itens = $('.tableListProdutos tbody tr td');

                    // Exemplo de envio ao servidor (você pode adaptar conforme a sua API)
                    $.post('/cart/finalize', {
                            methods,
                            amounts,
                            splitPayment,
                            _token: "{{ csrf_token() }}"
                        })
                        .done(function(json) {
                            if (json.success) {
                                paymentModal.hide();
                                loadCart();
                                $('.pdv-products.row .pdv-product[name="produtos"]').closest('.col').remove();
                                $('.alert-venda-finalizada').show();
                            }
                        });
                });

                function showAlert(msg, type = 'info') {
                    const $a = $(`
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
                    // insere no topo do container
                    $('.container').prepend($a);
                    setTimeout(() => $a.alert('close'), 5000);
                }

                $('#splitPayment').on('change', function() {
                    const checked = this.checked;
                    $('#secondPaymentContainer').toggleClass('d-none', !checked);
                    $('#splitValuesContainer').toggleClass('d-none', !checked);

                    if (checked) {
                        // Pega o total (texto "R$ 123,45") e converte para número 123.45
                        const total = parseReal($('#paymentModalTotal').text());

                        // Inicializa valores: tudo em 1, zero em 2
                        $('#paymentAmount1').val(formatReal(total));
                        $('#paymentAmount2').val(formatReal(0));
                    } else {
                        // Limpa os campos se desmarcar
                        $('#paymentAmount1, #paymentAmount2').val('');
                    }
                });

                $('#paymentAmount1').off('input').on('keyup', function() {
                    // 1) Pega só dígitos
                    let v = this.value.replace(/\D/g, '');

                    // 2) Transforma em número com duas casas
                    v = (v / 100).toFixed(2);

                    // 3) Troca ponto por vírgula
                    v = v.toString().replace('.', ',');

                    // 4) Coloca ponto a cada milhar
                    v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    // 5) Prefixa com R$
                    this.value = 'R$ ' + v;

                    // 6) Recalcula o segundo valor
                    const val1 = parseFloat(v.replace(/\./g, '').replace(',', '.')) || 0;
                    const total = parseFloat(
                        $('#paymentModalTotal').text()
                        .replace(/[R$ \.]/g, '') // remove R$, ponto e NBSP
                        .replace(',', '.')
                    ) || 0;
                    const val2 = (total - val1).toFixed(2);

                    // 7) Formata val2 igual
                    let v2 = val2.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    $('#paymentAmount2').val('R$ ' + v2);
                });

                $('#paymentModal').on('hidden.bs.modal', function() {
                    // Remove a classe que trava o scroll do body
                    $('body').removeClass('modal-open');
                    // Remove qualquer backdrop que tenha sobrado no DOM
                    $('.modal-backdrop').remove();
                });

                function parseReal(str) {
                    if (!str) return 0;
                    return parseFloat(
                        str
                        .replace(/\s/g, '') // remove espaços
                        .replace('R$', '') // remove R$
                        .replace(/\./g, '') // remove separador de milhares
                        .replace(',', '.') // vírgula → ponto
                    ) || 0;
                }

                // Converte número → "R$ 1.234,56"
                function formatReal(num) {
                    return num.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            }


            document.querySelectorAll('.pdv-product').forEach(item => {
                item.addEventListener('click', () => {
                    const name = item.dataset.name;
                    const price = parseFloat(item.dataset.price);

                    total += price;

                    document.querySelector('.pdv-cart-items').insertAdjacentHTML(
                        'beforeend',
                        `<div class="cart-item">
                    <span>${name}</span>
                    <span>R$ ${price.toFixed(2).replace('.', ',')}</span>
                </div>`
                    );

                    document.querySelector('#pdvTotal').textContent = 'R$ ' + total.toFixed(2).replace('.',
                        ',');
                });
            });
        </script>
    @endpush
