@extends('layouts.app')

@section('title', 'Agendamentos')

@section('breadcrumb')
<li class="breadcrumb-item active">Agendamentos</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Agendamentos</h3>
        <div class="card-tools">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Agendamento
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Cliente</th>
                        <th>Barbeiro</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->client->name }}</td>
                            <td>{{ $appointment->barber->user->name }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->start_time->format('d/m/Y') }}</td>
                            <td>{{ $appointment->start_time->format('H:i') }}</td>
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
                            <td>
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Nenhum agendamento encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection 