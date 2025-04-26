@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
<li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Usuário</h3>
    </div>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Erro!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>
                                @if($error == 'The roles field is required.')
                                    O campo perfil é obrigatório.
                                @elseif($error == 'The password field is required.')
                                    O campo senha é obrigatório.
                                @elseif($error == 'The email field is required.')
                                    O campo email é obrigatório.
                                @elseif($error == 'The name field is required.')
                                    O campo nome é obrigatório.
                                @else
                                    {{ $error }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">O campo nome é obrigatório.</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="invalid-feedback">O campo email é obrigatório.</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nova Senha <small class="text-muted">(deixe em branco para manter a atual)</small></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <span class="invalid-feedback">O campo senha é obrigatório.</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <label for="roles">Perfil</label>
                <select class="form-control @error('roles') is-invalid @enderror" id="roles" name="roles[]" required>
                    <option value="">Selecione um perfil</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ (old('roles', $user->roles->pluck('id')->toArray()) && in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('roles')
                    <span class="invalid-feedback">O campo perfil é obrigatório.</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Ativo</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection 