@extends('layouts.app')

@section('title', 'Detalhes do Serviço')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('services.index') }}">Serviços</a></li>
<li class="breadcrumb-item active">Detalhes do Serviço</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Serviço</h3>
        <div class="card-tools">
            <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('services.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">ID</th>
                        <td>{{ $service->id }}</td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td>{{ $service->name }}</td>
                    </tr>
                    <tr>
                        <th>Preço</th>
                        <td>R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Duração</th>
                        <td>{{ $service->duration }} minutos</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($service->is_active)
                            <span class="badge badge-success">Ativo</span>
                            @else
                            <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Criado em</th>
                        <td>{{ $service->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Atualizado em</th>
                        <td>{{ $service->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Descrição</h3>
                    </div>
                    <div class="card-body">
                        @if($service->description)
                            {{ $service->description }}
                        @else
                            <p class="text-muted">Nenhuma descrição disponível.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 