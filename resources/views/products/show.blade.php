@extends('layouts.app')

@section('title', 'Detalhes do Produto')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
<li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Produto</h3>
        <div class="card-tools">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($product->photo)
                    <div class="text-center mb-4">
                        <img src="{{ Storage::url($product->photo) }}" alt="Foto do Produto" class="img-fluid rounded">
                    </div>
                @else
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/no-image.png') }}" alt="Sem Foto" class="img-fluid rounded">
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Preço de Venda</th>
                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Preço de Custo</th>
                        <td>R$ {{ number_format($product->cost_price, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Estoque Inicial</th>
                        <td>{{ $product->initial_stock }}</td>
                    </tr>
                    <tr>
                        <th>Estoque Atual</th>
                        <td>{{ $product->stock }}</td>
                    </tr>
                    <tr>
                        <th>Estoque Mínimo</th>
                        <td>{{ $product->min_stock }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Data de Criação</th>
                        <td>{{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Última Atualização</th>
                        <td>{{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>

                @if($product->description)
                    <div class="mt-4">
                        <h5>Descrição</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 