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
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th style="width: 120px">Preço</th>
                        <th style="width: 100px">Duração</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ Str::limit($service->description, 50) }}</td>
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
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
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
                            <td colspan="7" class="text-center">Nenhum serviço encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection 