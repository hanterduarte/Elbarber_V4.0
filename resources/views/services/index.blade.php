@extends('layouts.app')

@section('title', 'Serviços')

@section('breadcrumb')
<li class="breadcrumb-item active">Serviços</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Serviços</h3>
        <div class="card-tools">
            <a href="{{ route('services.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Serviço
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                        <td>{{ $service->duration }} min</td>
                        <td>
                            @if($service->is_active)
                            <span class="badge badge-success">Ativo</span>
                            @else
                            <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('services.show', $service) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum serviço encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $services->links() }}
    </div>
</div>
@endsection 