@extends('layouts.admin')

@section('title', 'Detalhes do Cliente')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
<li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Cliente</h3>
        <div class="card-tools">
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
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
                        <td>{{ $client->email ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Telefone</th>
                        <td>{{ $client->phone }}</td>
                    </tr>
                    <tr>
                        <th>Data de Nascimento</th>
                        <td>{{ $client->birth_date ? date('d/m/Y', strtotime($client->birth_date)) : 'Não informada' }}</td>
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
                        <th>Data de Criação</th>
                        <td>{{ $client->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Última Atualização</th>
                        <td>{{ $client->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">CEP</th>
                        <td>{{ $client->zip_code ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Endereço</th>
                        <td>{{ $client->street ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Número</th>
                        <td>{{ $client->number ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Complemento</th>
                        <td>{{ $client->complement ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Bairro</th>
                        <td>{{ $client->district ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Cidade</th>
                        <td>{{ $client->city ?? 'Não informado' }}</td>
                    </tr>
                    <tr>
                        <th>Ponto de Referência</th>
                        <td>{{ $client->reference_point ?? 'Não informado' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 