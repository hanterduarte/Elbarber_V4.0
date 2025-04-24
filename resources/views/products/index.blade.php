@extends('layouts.app')

@section('title', 'Produtos')

@section('styles')
<style>
.product-thumbnail-container {
    position: relative;
    display: inline-block;
}

.product-thumbnail {
    width: 35px;
    height: 35px;
    object-fit: cover;
    border-radius: 4px;
}
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Produtos</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Produtos</h3>
        <div class="card-tools">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Produto
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th style="width: 50px">Foto</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th style="width: 120px">Preço</th>
                        <th style="width: 100px">Estoque</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td class="text-center">
                                <div class="product-thumbnail-container">
                                    @if($product->photo)
                                        <img src="{{ Storage::url($product->photo) }}" 
                                             alt="Foto do Produto" 
                                             class="product-thumbnail">
                                    @else
                                        <img src="{{ asset('img/no-image.png') }}" 
                                             alt="Sem Foto" 
                                             class="product-thumbnail">
                                    @endif
                                </div>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ Str::limit($product->description, 50) }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection 