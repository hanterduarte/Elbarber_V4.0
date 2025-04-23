@extends('layouts.admin')

@section('title', 'Perfis')

@section('breadcrumb')
    <li class="breadcrumb-item active">Perfis</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Perfis</h3>
            <div class="card-tools">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Novo Perfil
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($roles->isEmpty())
                <div class="alert alert-info">
                    Nenhum perfil cadastrado.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px">ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th style="width: 150px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info" title="Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!in_array($role->name, ['admin', 'manager', 'barber', 'receptionist']))
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este perfil?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection 