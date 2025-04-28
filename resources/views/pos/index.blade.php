@extends('layouts.app')

@section('title', 'PDV')

@section('breadcrumb')
<li class="breadcrumb-item active">PDV</li>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

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
                                                data-price="{{ $service->price }}"
                                                data-is-active="{{ $service->is_active }}">
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
                                                data-stock="{{ $product->stock }}"
                                                data-is-active="{{ $product->is_active }}">
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

        <!-- Nova seção de atalhos de função -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Atalhos de Função</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info btn-block mb-2" id="btn-open-cashier">
                            <span class="badge badge-light">F1</span> Abertura de Caixa
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-warning btn-block mb-2" id="btn-cash-withdrawal">
                            <span class="badge badge-light">F2</span> Sangria de Caixa
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success btn-block mb-2" id="btn-cash-reinforcement">
                            <span class="badge badge-light">F3</span> Reforço de Caixa
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger btn-block mb-2" id="btn-close-cashier">
                            <span class="badge badge-light">F4</span> Fechamento de Caixa
                        </button>
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
                <form id="posForm" action="{{ route('pdv.sale') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="client_id">Cliente</label>
                        <select class="form-control select2" id="client_id" name="client_id">
                            <option value="">Selecione um cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th style="width: 80px">Qtd</th>
                                    <th style="width: 100px">Valor</th>
                                    <th style="width: 100px">Total</th>
                                    <th style="width: 40px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Os itens do carrinho serão inseridos aqui via JavaScript -->
                            </tbody>
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
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discount_percent" name="discount_percent" value="0" min="0" max="100">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" value="0" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="button" class="btn btn-warning btn-block" id="clear-discount">
                                    <i class="fas fa-eraser"></i> Limpar Desconto
                                </button>
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
                                <input type="number" class="form-control payment-amount" name="payments[0][amount]" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label>Troco</label>
                                <h5 id="troco" class="text-primary mb-0">R$ 0,00</h5>
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

                    <div class="btn-group-vertical w-100">
                        <button type="button" class="btn btn-danger mb-2" id="cancel-sale">
                            <i class="fas fa-times"></i> Cancelar Venda
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Finalizar Venda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    });
</script>
<script src="{{ asset('js/pos.js') }}"></script>
@endpush
@endsection 