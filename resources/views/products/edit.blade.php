@extends('layouts.app')

@section('title', 'Editar Produto')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
<li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Produto</h3>
    </div>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                <label for="name">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="photo">Foto do Produto</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                        <label class="custom-file-label" for="photo">{{ $product->photo ? basename($product->photo) : 'Escolher arquivo' }}</label>
                    </div>
                </div>
                @error('photo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                @if($product->photo)
                    <div class="mt-2">
                        <img src="{{ Storage::url($product->photo) }}" alt="Foto do Produto" class="img-thumbnail" style="max-height: 200px">
                        <input type="hidden" name="remove_photo" id="remove_photo" value="0">
                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePhoto()">
                            <i class="fas fa-trash"></i> Remover Foto
                        </button>
                    </div>
                @endif
                <div id="preview-container" class="mt-2 @if(!$product->photo) d-none @endif">
                    <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Preço de Venda <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_price">Preço de Custo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>
                            <input type="number" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" step="0.01" min="0">
                            @error('cost_price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="initial_stock">Estoque Inicial</label>
                        <input type="number" class="form-control @error('initial_stock') is-invalid @enderror" id="initial_stock" name="initial_stock" value="{{ old('initial_stock', $product->initial_stock) }}" min="0">
                        @error('initial_stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stock">Estoque Atual <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                        @error('stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="min_stock">Estoque Mínimo</label>
                        <input type="number" class="form-control @error('min_stock') is-invalid @enderror" id="min_stock" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" min="0">
                        @error('min_stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Produto Ativo</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Máscara para os campos de preço
        $('#price, #cost_price').inputmask('currency', {
            radixPoint: ',',
            groupSeparator: '.',
            allowMinus: false,
            prefix: '',
            digits: 2,
            digitsOptional: false,
            rightAlign: false,
            unmaskAsNumber: true
        });

        // Preview da imagem
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').removeClass('d-none');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview do nome do arquivo selecionado
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            readURL(this);
        });
    });

    // Função para remover a foto
    function removePhoto() {
        if (confirm('Tem certeza que deseja remover a foto?')) {
            $('#remove_photo').val('1');
            $('.img-thumbnail').hide();
            $('.custom-file-label').html('Escolher arquivo');
            $('#photo').val('');
        }
    }
</script>
@endpush 