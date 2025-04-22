@extends('layouts.app')

@section('title', 'Editar Barbeiro')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('barbers.index') }}">Barbeiros</a></li>
<li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Barbeiro</h3>
    </div>
    <form action="{{ route('barbers.update', $barber->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $barber->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $barber->email) }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $barber->phone) }}" required>
                @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="specialties">Especialidades</label>
                <textarea class="form-control @error('specialties') is-invalid @enderror" id="specialties" name="specialties" rows="3">{{ old('specialties', $barber->specialties) }}</textarea>
                @error('specialties')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nova Senha</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                <small class="form-text text-muted">Deixe em branco para manter a senha atual</small>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $barber->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Barbeiro Ativo</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('barbers.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#phone').inputmask('(99) 99999-9999');
    });
</script>
@endpush 