@extends('layouts.app')

@section('title', 'Detalhes da Venda')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pos.index') }}">Ponto de Venda</a></li>
<li class="breadcrumb-item"><a href="{{ route('pos.history') }}">Histórico de Vendas</a></li>
<li class="breadcrumb-item active">Detalhes da Venda</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalhes da Venda #{{ $sale->id }}</h3>
                <div class="card-tools">
                    <a href="{{ route('pos.print', $sale) }}" class="btn btn-secondary btn-sm" target="_blank">
                        <i class="fas fa-print"></i> Imprimir
                    </a>
                    <a href="{{ route('pos.history') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informações da Venda</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px">Data/Hora</th>
                                <td>{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Cliente</th>
                                <td>{{ $sale->client->name ?? 'Cliente não informado' }}</td>
                            </tr>
                            <tr>
                                <th>Forma de Pagamento</th>
                                <td>
                                    @switch($sale->payment_method)
                                        @case('money')
                                            <span class="badge badge-success">Dinheiro</span>
                                            @break
                                        @case('credit_card')
                                            <span class="badge badge-info">Cartão de Crédito</span>
                                            @break
                                        @case('debit_card')
                                            <span class="badge badge-primary">Cartão de Débito</span>
                                            @break
                                        @case('pix')
                                            <span class="badge badge-warning">PIX</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ $sale->payment_method }}</span>
                                    @endswitch
                                </td>
                            </tr>
                            @if($sale->payment_method === 'money')
                                <tr>
                                    <th>Valor Recebido</th>
                                    <td>R$ {{ number_format($sale->received_amount, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Troco</th>
                                    <td>R$ {{ number_format($sale->change_amount, 2, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Observações</th>
                                <td>{{ $sale->notes ?? 'Nenhuma observação' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Totais</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px">Subtotal</th>
                                <td>R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Desconto</th>
                                <td>{{ $sale->discount }}%</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="font-weight-bold">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h5 class="mt-4">Itens da Venda</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Tipo</th>
                                <th>Preço Unitário</th>
                                <th>Quantidade</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if($item->type === 'product')
                                            <span class="badge badge-info">Produto</span>
                                        @else
                                            <span class="badge badge-success">Serviço</span>
                                        @endif
                                    </td>
                                    <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Histórico</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div>
                        <i class="fas fa-shopping-cart bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ $sale->created_at->format('H:i') }}</span>
                            <h3 class="timeline-header">Venda Realizada</h3>
                            <div class="timeline-body">
                                Venda registrada por {{ $sale->user->name }}
                            </div>
                        </div>
                    </div>

                    @if($sale->payment_method === 'money')
                        <div>
                            <i class="fas fa-money-bill bg-success"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $sale->created_at->format('H:i') }}</span>
                                <h3 class="timeline-header">Pagamento em Dinheiro</h3>
                                <div class="timeline-body">
                                    Valor recebido: R$ {{ number_format($sale->received_amount, 2, ',', '.') }}<br>
                                    Troco: R$ {{ number_format($sale->change_amount, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @elseif($sale->payment_method === 'credit_card')
                        <div>
                            <i class="fas fa-credit-card bg-info"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $sale->created_at->format('H:i') }}</span>
                                <h3 class="timeline-header">Pagamento com Cartão de Crédito</h3>
                                <div class="timeline-body">
                                    Transação aprovada
                                </div>
                            </div>
                        </div>
                    @elseif($sale->payment_method === 'debit_card')
                        <div>
                            <i class="fas fa-credit-card bg-primary"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $sale->created_at->format('H:i') }}</span>
                                <h3 class="timeline-header">Pagamento com Cartão de Débito</h3>
                                <div class="timeline-body">
                                    Transação aprovada
                                </div>
                            </div>
                        </div>
                    @elseif($sale->payment_method === 'pix')
                        <div>
                            <i class="fas fa-qrcode bg-warning"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $sale->created_at->format('H:i') }}</span>
                                <h3 class="timeline-header">Pagamento via PIX</h3>
                                <div class="timeline-body">
                                    Transação confirmada
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 