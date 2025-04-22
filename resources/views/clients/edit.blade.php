@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
<li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Cliente</h3>
    </div>
    <form action="{{ route('clients.update', $client->id) }}" method="POST">
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
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $client->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $client->email) }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" required>
                @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Endereço</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $client->address) }}</textarea>
                @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Cliente Ativo</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection 