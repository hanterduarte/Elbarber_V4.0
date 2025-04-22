@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
<li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Usuário</h3>
        <div class="card-tools">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Nome</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Perfil</th>
                <td>{{ ucfirst($user->roles->first()->name ?? 'Sem perfil') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($user->is_active)
                        <span class="badge badge-success">Ativo</span>
                    @else
                        <span class="badge badge-danger">Inativo</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 