@extends('layouts.app')

@section('title', 'Histórico de Vendas')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pos.index') }}">Ponto de Venda</a></li>
<li class="breadcrumb-item active">Histórico de Vendas</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Histórico de Vendas</h3>
        <div class="card-tools">
            <form action="{{ route('pos.history') }}" method="GET" class="form-inline">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Itens</th>
                        <th>Subtotal</th>
                        <th>Desconto</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Data</th>
                        <th style="width: 100px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->client->name ?? 'Cliente não informado' }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($sale->items as $item)
                                        <li>
                                            {{ $item->quantity }}x {{ $item->name }}
                                            (R$ {{ number_format($item->price, 2, ',', '.') }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</td>
                            <td>{{ $sale->discount }}%</td>
                            <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
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
                            <td>{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a href="{{ route('pos.show', $sale) }}" class="btn btn-info btn-sm" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pos.print', $sale) }}" class="btn btn-secondary btn-sm" title="Imprimir" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Nenhuma venda encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total do Período:</th>
                        <td>R$ {{ number_format($sales->sum('subtotal'), 2, ',', '.') }}</td>
                        <td>-</td>
                        <td>R$ {{ number_format($sales->sum('total'), 2, ',', '.') }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $sales->links() }}
    </div>
</div>
@endsection 