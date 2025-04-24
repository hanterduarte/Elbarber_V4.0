@extends('layouts.app')

@section('title', 'Detalhes do Barbeiro')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('barbers.index') }}">Barbeiros</a></li>
<li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Barbeiro</h3>
        <div class="card-tools">
            <a href="{{ route('barbers.edit', $barber->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('barbers.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td>{{ $barber->id }}</td>
            </tr>
            <tr>
                <th>Nome</th>
                <td>{{ $barber->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $barber->user->email }}</td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td>{{ $barber->phone }}</td>
            </tr>
            <tr>
                <th>Especialidades</th>
                <td>{{ $barber->specialties ?? 'Não informadas' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($barber->is_active)
                        <span class="badge badge-success">Ativo</span>
                    @else
                        <span class="badge badge-danger">Inativo</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td>{{ $barber->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td>{{ $barber->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('barbers.destroy', $barber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este barbeiro?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>

@if($barber->appointments->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Agendamentos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barber->appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->client->name }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->date ? $appointment->date->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $appointment->time ? $appointment->time->format('H:i') : 'N/A' }}</td>
                            <td>
                                @switch($appointment->status)
                                    @case('scheduled')
                                        <span class="badge badge-info">Agendado</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge badge-success">Confirmado</span>
                                        @break
                                    @case('completed')
                                        <span class="badge badge-primary">Concluído</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge badge-danger">Cancelado</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $appointment->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info btn-sm" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection 