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
    <form action="{{ route('barbers.update', $barber->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <!-- Campo oculto para prevenir autopreenchimento -->
        <input type="text" style="display:none">
        <input type="password" style="display:none">
        
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

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $barber->user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $barber->user->email) }}" required autocomplete="off">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Nova Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                        <small class="form-text text-muted">Deixe em branco para manter a senha atual</small>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="photo">Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            <label class="custom-file-label" for="photo">Escolher arquivo</label>
                        </div>
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="mt-2">
                            <img id="photo-preview" src="{{ $barber->photo ? asset('storage/' . $barber->photo) : asset('images/default-avatar.png') }}" class="img-fluid" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $barber->phone) }}">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="commission_rate">Comissão (%)</label>
                        <input type="number" class="form-control @error('commission_rate') is-invalid @enderror" id="commission_rate" name="commission_rate" value="{{ old('commission_rate', $barber->commission_rate) }}" min="0" max="100" step="0.01">
                        @error('commission_rate')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="bio">Biografia</label>
                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $barber->bio) }}</textarea>
                @error('bio')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
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

    // Preview da foto
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#photo-preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#photo").change(function() {
        readURL(this);
        var fileName = $(this).val().split("\\").pop();
        $(this).next('.custom-file-label').html(fileName);
    });
});
</script>
@endpush 