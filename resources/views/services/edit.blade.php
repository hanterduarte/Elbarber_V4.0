@extends('layouts.app')

@section('title', 'Editar Serviço')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('services.index') }}">Serviços</a></li>
<li class="breadcrumb-item active">Editar Serviço</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Serviço</h3>
    </div>
    <form action="{{ route('services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $service->name) }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">Preço</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required>
                </div>
                @error('price')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="duration">Duração (minutos)</label>
                <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" min="1" required>
                @error('duration')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Ativo</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection 