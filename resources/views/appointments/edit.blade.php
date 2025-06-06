@extends('layouts.app')

@section('title', 'Editar Agendamento')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Agendamentos</a></li>
<li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Agendamento</h3>
    </div>
    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
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
                <label for="client_id">Cliente</label>
                <select class="form-control @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $appointment->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="barber_id">Barbeiro <span class="text-danger">*</span></label>
                <select class="form-control select2 @error('barber_id') is-invalid @enderror" id="barber_id" name="barber_id" required>
                    <option value="">Selecione um barbeiro</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}" {{ old('barber_id', $appointment->barber_id) == $barber->id ? 'selected' : '' }}>
                            {{ $barber->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('barber_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="service_id">Serviço <span class="text-danger">*</span></label>
                <select class="form-control select2 @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                    <option value="">Selecione um serviço</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Data <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $appointment->start_time->format('Y-m-d')) }}" required>
                        @error('date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Horário <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time', $appointment->start_time->format('H:i')) }}" required>
                        @error('time')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>Agendado</option>
                    <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Observações</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                @error('notes')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    });
</script>
@endpush 