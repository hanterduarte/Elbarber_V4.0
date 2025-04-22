@extends('layouts.app')

@section('title', 'Detalhes do Cliente')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
<li class="breadcrumb-item active">Detalhes do Cliente</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Cliente</h3>
        <div class="card-tools">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td>{{ $client->id }}</td>
            </tr>
            <tr>
                <th>Nome</th>
                <td>{{ $client->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $client->email }}</td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td>{{ $client->phone }}</td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td>{{ $client->address ?? 'Não informado' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($client->is_active)
                        <span class="badge badge-success">Ativo</span>
                    @else
                        <span class="badge badge-danger">Inativo</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Data de Cadastro</th>
                <td>{{ $client->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td>{{ $client->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 