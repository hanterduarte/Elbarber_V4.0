@extends('layouts.app')

@section('title', 'PDV')

@section('breadcrumb')
<li class="breadcrumb-item active">PDV</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produtos e Serviços</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" id="search" class="form-control float-right" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="posTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="services-tab" data-toggle="tab" href="#services" role="tab">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab">Produtos</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="posTabContent">
                    <div class="tab-pane fade show active" id="services" role="tabpanel">
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $service->name }}</h5>
                                            <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                                            <p class="card-text">
                                                <strong>Preço:</strong> R$ {{ number_format($service->price, 2, ',', '.') }}<br>
                                                <strong>Duração:</strong> {{ $service->duration }} min
                                            </p>
                                            <button type="button" class="btn btn-primary btn-block add-item" 
                                                data-id="{{ $service->id }}"
                                                data-type="service"
                                                data-name="{{ $service->name }}"
                                                data-price="{{ $service->price }}">
                                                Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="products" role="tabpanel">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                            <p class="card-text">
                                                <strong>Preço:</strong> R$ {{ number_format($product->price, 2, ',', '.') }}<br>
                                                <strong>Estoque:</strong> {{ $product->stock }}
                                            </p>
                                            <button type="button" class="btn btn-primary btn-block add-item" 
                                                data-id="{{ $product->id }}"
                                                data-type="product"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->price }}"
                                                data-stock="{{ $product->stock }}">
                                                Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Carrinho</h3>
            </div>
            <div class="card-body">
                <form id="posForm" action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="client_id">Cliente</label>
                        <select class="form-control" id="client_id" name="client_id">
                            <option value="">Selecione um cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th style="width: 100px">Qtd</th>
                                    <th style="width: 120px">Valor</th>
                                    <th style="width: 120px">Total</th>
                                    <th style="width: 60px"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                    <td colspan="2"><span id="subtotal">R$ 0,00</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-group">
                        <label>Desconto</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discount_percent" name="discount_percent" value="0" min="0" max="100">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" value="0" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Total</label>
                        <h3 id="total" class="text-success">R$ 0,00</h3>
                    </div>

                    <div id="payment-methods">
                        <div class="payment-method">
                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select class="form-control payment-type" name="payments[0][method]" required>
                                    <option value="cash">Dinheiro</option>
                                    <option value="credit_card">Cartão de Crédito</option>
                                    <option value="debit_card">Cartão de Débito</option>
                                    <option value="pix">PIX</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="number" class="form-control payment-amount" name="payments[0][amount]" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-info btn-block mb-3" id="add-payment">
                        <i class="fas fa-plus"></i> Adicionar Forma de Pagamento
                    </button>

                    <div class="form-group">
                        <label for="notes">Observações</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Finalizar Venda
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let cart = [];
    let total = 0;
    let subtotal = 0;
    let discountPercent = 0;
    let discountValue = 0;
    let paymentIndex = 1;

    $('.add-item').click(function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const name = $(this).data('name');
        const price = $(this).data('price');
        const stock = $(this).data('stock');

        const existingItem = cart.find(item => item.id === id && item.type === type);
        if (existingItem) {
            if (type === 'product' && existingItem.quantity >= stock) {
                alert('Quantidade máxima em estoque atingida!');
                return;
            }
            existingItem.quantity++;
        } else {
            cart.push({
                id: id,
                type: type,
                name: name,
                price: price,
                quantity: 1
            });
        }

        updateCart();
    });

    function updateCart() {
        const tbody = $('#cart tbody');
        tbody.empty();
        subtotal = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm quantity" 
                            value="${item.quantity}" min="1" data-index="${index}">
                    </td>
                    <td>R$ ${item.price.toFixed(2)}</td>
                    <td>R$ ${itemTotal.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        $('#subtotal').text(`R$ ${subtotal.toFixed(2)}`);
        updateTotal();
    }

    function updateTotal() {
        discountPercent = parseFloat($('#discount_percent').val()) || 0;
        discountValue = parseFloat($('#discount_value').val()) || 0;
        
        // Se o desconto em valor for maior que 0, ignora o desconto percentual
        if (discountValue > 0) {
            total = subtotal - discountValue;
            // Atualiza o percentual equivalente
            if (subtotal > 0) {
                const equivalentPercent = (discountValue / subtotal) * 100;
                $('#discount_percent').val(equivalentPercent.toFixed(2));
            }
        } else {
            const discountAmount = (subtotal * discountPercent) / 100;
            total = subtotal - discountAmount;
            // Atualiza o valor equivalente
            $('#discount_value').val(discountAmount.toFixed(2));
        }

        // Garante que o total não seja negativo
        total = Math.max(0, total);
        
        $('#total').text(`R$ ${total.toFixed(2)}`);
        
        // Atualiza o valor do primeiro método de pagamento para o total
        $('.payment-amount').first().val(total.toFixed(2));
    }

    $(document).on('change', '.quantity', function() {
        const index = $(this).data('index');
        const quantity = parseInt($(this).val());

        if (quantity < 1) {
            $(this).val(1);
            cart[index].quantity = 1;
        } else {
            if (cart[index].type === 'product' && quantity > cart[index].stock) {
                alert('Quantidade maior que o estoque disponível!');
                $(this).val(cart[index].stock);
                cart[index].quantity = cart[index].stock;
            } else {
                cart[index].quantity = quantity;
            }
        }

        updateCart();
    });

    $(document).on('click', '.remove-item', function() {
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });

    $('#discount_percent').change(function() {
        $('#discount_value').val(0); // Limpa o desconto em valor
        updateTotal();
    });

    $('#discount_value').change(function() {
        if ($(this).val() > 0) {
            $('#discount_percent').val(0); // Limpa o desconto percentual
        }
        updateTotal();
    });

    $('#add-payment').click(function() {
        const newPayment = `
            <div class="payment-method">
                <hr>
                <div class="form-group">
                    <label>Forma de Pagamento</label>
                    <select class="form-control payment-type" name="payments[${paymentIndex}][method]" required>
                        <option value="cash">Dinheiro</option>
                        <option value="credit_card">Cartão de Crédito</option>
                        <option value="debit_card">Cartão de Débito</option>
                        <option value="pix">PIX</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Valor</label>
                    <input type="number" class="form-control payment-amount" name="payments[${paymentIndex}][amount]" step="0.01" required>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-payment">
                    <i class="fas fa-trash"></i> Remover
                </button>
            </div>
        `;
        $('#payment-methods').append(newPayment);
        paymentIndex++;
    });

    $(document).on('click', '.remove-payment', function() {
        $(this).closest('.payment-method').remove();
    });

    $('#posForm').submit(function(e) {
        e.preventDefault();

        if (cart.length === 0) {
            alert('Adicione itens ao carrinho!');
            return;
        }

        // Valida o total dos pagamentos
        let totalPayments = 0;
        $('.payment-amount').each(function() {
            totalPayments += parseFloat($(this).val()) || 0;
        });

        if (Math.abs(totalPayments - total) > 0.01) {
            alert('A soma dos pagamentos deve ser igual ao total da venda!');
            return;
        }

        const formData = {
            client_id: $('#client_id').val(),
            discount_percent: $('#discount_percent').val(),
            discount_value: $('#discount_value').val(),
            notes: $('#notes').val(),
            items: cart.map(item => ({
                id: item.id,
                type: item.type,
                quantity: item.quantity
            })),
            payments: []
        };

        // Coleta os pagamentos
        $('.payment-method').each(function(index) {
            formData.payments.push({
                method: $(this).find('.payment-type').val(),
                amount: parseFloat($(this).find('.payment-amount').val())
            });
        });

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Venda realizada com sucesso!');
                cart = [];
                updateCart();
                $('#posForm')[0].reset();
                $('#payment-methods').html(`
                    <div class="payment-method">
                        <div class="form-group">
                            <label>Forma de Pagamento</label>
                            <select class="form-control payment-type" name="payments[0][method]" required>
                                <option value="cash">Dinheiro</option>
                                <option value="credit_card">Cartão de Crédito</option>
                                <option value="debit_card">Cartão de Débito</option>
                                <option value="pix">PIX</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" class="form-control payment-amount" name="payments[0][amount]" step="0.01" required>
                        </div>
                    </div>
                `);
                paymentIndex = 1;
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.error || 'Erro ao realizar a venda. Tente novamente.');
            }
        });
    });

    $('#search').keyup(function() {
        const search = $(this).val().toLowerCase();
        $('.card').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).closest('.col-md-4').toggle(text.indexOf(search) > -1);
        });
    });
});
</script>
@endpush
@endsection 