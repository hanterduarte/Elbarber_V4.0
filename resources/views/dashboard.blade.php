@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Today's Revenue -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R$ {{ number_format($todayRevenue, 2, ',', '.') }}</h3>
                    <p>Receita do Dia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Current Cash Register -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Caixa {{ $currentCashRegister ? 'Aberto' : 'Fechado' }}</h3>
                    <p>
                        @if($currentCashRegister)
                            Aberto por: {{ $currentCashRegister->user->name }}<br>
                            Abertura: {{ $currentCashRegister->opened_at->format('d/m/Y H:i') }}
                        @else
                            Nenhum caixa aberto
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </div>

        <!-- Last Closed Register -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Último Caixa</h3>
                    <p>
                        @if($lastClosedRegister)
                            Fechado por: {{ $lastClosedRegister->closedByUser->name }}<br>
                            Total: R$ {{ number_format($lastClosedRegister->final_amount, 2, ',', '.') }}
                        @else
                            Nenhum caixa fechado
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $todayAppointments->count() }}</h3>
                    <p>Agendamentos Hoje</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agendamentos de Hoje</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Horário</th>
                                    <th>Cliente</th>
                                    <th>Barbeiro</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->start_time->format('H:i') }}</td>
                                        <td>{{ $appointment->client->name }}</td>
                                        <td>{{ $appointment->barber->user->name }}</td>
                                        <td>{{ $appointment->service->name }}</td>
                                        <td>
                                            @switch($appointment->status)
                                                @case('scheduled')
                                                    <span class="badge badge-info">Agendado</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge badge-primary">Confirmado</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge badge-success">Concluído</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge badge-danger">Cancelado</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum agendamento para hoje</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Próximos Agendamentos</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Cliente</th>
                                    <th>Barbeiro</th>
                                    <th>Serviço</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->start_time->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->start_time->format('H:i') }}</td>
                                        <td>{{ $appointment->client->name }}</td>
                                        <td>{{ $appointment->barber->user->name }}</td>
                                        <td>{{ $appointment->service->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum agendamento futuro</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop 