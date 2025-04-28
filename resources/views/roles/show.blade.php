@extends('layouts.admin')

@section('title', 'Detalhes do Perfil')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Perfis</a></li>
    <li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informações do Perfil</h3>
            <div class="card-tools">
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 200px">ID</th>
                            <td>{{ $role->id }}</td>
                        </tr>
                        <tr>
                            <th>Nome</th>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <th>Descrição</th>
                            <td>{{ $role->description ?: 'Nenhuma descrição fornecida' }}</td>
                        </tr>
                        <tr>
                            <th>Data de Criação</th>
                            <td>{{ $role->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização</th>
                            <td>{{ $role->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h4 class="mt-4">Permissões</h4>
            @if($role->permissions->isEmpty())
                <div class="alert alert-info">
                    Este perfil não possui permissões atribuídas.
                </div>
            @else
                <div class="row">
                    @foreach($role->permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                {{ $permission->description }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @if(!in_array($role->name, ['admin', 'manager', 'barber', 'receptionist']))
            <div class="card-footer">
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este perfil?')">
                        <i class="fas fa-trash mr-1"></i> Excluir Perfil
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection 