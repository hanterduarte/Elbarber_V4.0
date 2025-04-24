@extends('layouts.app')

@section('title', 'Barbeiros')

@section('breadcrumb')
<li class="breadcrumb-item active">Barbeiros</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Barbeiros</h3>
        <div class="card-tools">
            <a href="{{ route('barbers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Barbeiro
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
                        <th>Email</th>
                        <th>Telefone</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbers as $barber)
                        <tr>
                            <td>{{ $barber->id }}</td>
                            <td>{{ $barber->user->name }}</td>
                            <td>{{ $barber->user->email }}</td>
                            <td>{{ $barber->phone }}</td>
                            <td>
                                @if($barber->is_active)
                                    <span class="badge badge-success">Ativo</span>
                                @else
                                    <span class="badge badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barbers.show', $barber->id) }}" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('barbers.edit', $barber->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('barbers.destroy', $barber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este barbeiro?');">
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
                            <td colspan="6" class="text-center">Nenhum barbeiro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $barbers->links() }}
        </div>
    </div>
</div>
@endsection 