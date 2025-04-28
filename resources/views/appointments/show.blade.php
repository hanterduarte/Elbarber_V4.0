@extends('layouts.app')

@section('title', 'Detalhes do Agendamento')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Agendamentos</a></li>
<li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Agendamento</h3>
        <div class="card-tools">
            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td>{{ $appointment->id }}</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td>{{ $appointment->client ? $appointment->client->name : 'Cliente Removido' }}</td>
            </tr>
            <tr>
                <th>Barbeiro</th>
                <td>{{ $appointment->barber && $appointment->barber->user ? $appointment->barber->user->name : 'Barbeiro Removido' }}</td>
            </tr>
            <tr>
                <th>Serviço</th>
                <td>{{ $appointment->service ? $appointment->service->name . ' - R$ ' . number_format($appointment->service->price, 2, ',', '.') : 'Serviço Removido' }}</td>
            </tr>
            <tr>
                <th>Data</th>
                <td>{{ $appointment->start_time->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Horário</th>
                <td>{{ $appointment->start_time->format('H:i') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($appointment->status == 'scheduled')
                        <span class="badge badge-primary">Agendado</span>
                    @elseif($appointment->status == 'confirmed')
                        <span class="badge badge-success">Confirmado</span>
                    @elseif($appointment->status == 'completed')
                        <span class="badge badge-info">Concluído</span>
                    @elseif($appointment->status == 'cancelled')
                        <span class="badge badge-danger">Cancelado</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td>{{ $appointment->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td>{{ $appointment->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>

        @if($appointment->notes)
            <div class="mt-4">
                <h5>Observações</h5>
                <p class="text-muted">{{ $appointment->notes }}</p>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
@endsection 