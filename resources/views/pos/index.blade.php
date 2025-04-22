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
                        <select class="form-control" id="client_id" name="client_id" required>
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
                                    <th style="width: 120px">Preço</th>
                                    <th style="width: 120px">Total</th>
                                    <th style="width: 60px"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td colspan="2"><span id="total">R$ 0,00</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Forma de Pagamento</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="cash">Dinheiro</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="debit_card">Cartão de Débito</option>
                            <option value="pix">PIX</option>
                        </select>
                    </div>

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
        total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

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

        $('#total').text(`R$ ${total.toFixed(2)}`);
    }

    $(document).on('change', '.quantity', function() {
        const index = $(this).data('index');
        const quantity = parseInt($(this).val());

        if (quantity < 1) {
            $(this).val(1);
            cart[index].quantity = 1;
        } else {
            cart[index].quantity = quantity;
        }

        updateCart();
    });

    $(document).on('click', '.remove-item', function() {
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });

    $('#posForm').submit(function(e) {
        e.preventDefault();

        if (cart.length === 0) {
            alert('Adicione itens ao carrinho!');
            return;
        }

        const formData = {
            client_id: $('#client_id').val(),
            payment_method: $('#payment_method').val(),
            notes: $('#notes').val(),
            items: cart.map(item => ({
                id: item.id,
                type: item.type,
                quantity: item.quantity
            }))
        };

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Venda realizada com sucesso!');
                cart = [];
                updateCart();
                $('#posForm')[0].reset();
            },
            error: function(xhr) {
                alert('Erro ao realizar a venda. Tente novamente.');
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