@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Gerenciamento de Caixa</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($currentCashRegister)
                        <div class="alert alert-info">
                            <h5>Status do Caixa: <strong>ABERTO</strong></h5>
                            <p>Aberto em: {{ $currentCashRegister->opened_at->format('d/m/Y H:i:s') }}</p>
                            <p>Valor inicial: R$ {{ number_format($currentCashRegister->initial_amount, 2, ',', '.') }}</p>
                            <p>Entradas em dinheiro: R$ {{ number_format($currentCashRegister->cash_in, 2, ',', '.') }}</p>
                            <p>Saídas em dinheiro: R$ {{ number_format($currentCashRegister->cash_out, 2, ',', '.') }}</p>
                            <p>Total em cartão: R$ {{ number_format($currentCashRegister->card_total, 2, ',', '.') }}</p>
                            <p>Total em PIX: R$ {{ number_format($currentCashRegister->pix_total, 2, ',', '.') }}</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#withdrawModal">
                                        Realizar Sangria
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#closeRegisterModal">
                                        Fechar Caixa
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h5>Status do Caixa: <strong>FECHADO</strong></h5>
                            @if($lastClosedCashRegister)
                                <p>Último fechamento: {{ $lastClosedCashRegister->closed_at->format('d/m/Y H:i:s') }}</p>
                            @endif
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#openRegisterModal">
                                Abrir Caixa
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Abertura de Caixa -->
<div class="modal fade" id="openRegisterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('cash-registers.open') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Abrir Caixa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Valor Inicial</label>
                        <input type="number" name="initial_amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Observações</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Abrir Caixa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Fechamento de Caixa -->
<div class="modal fade" id="closeRegisterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('cash-registers.close', ['cashRegister' => $currentCashRegister->id ?? '']) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Fechar Caixa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Valor Final em Caixa</label>
                        <input type="number" name="final_amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Observações</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Fechar Caixa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Sangria -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Realizar Sangria</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Valor da Sangria</label>
                    <input type="number" id="withdrawAmount" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea id="withdrawReason" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="performWithdraw()">Realizar Sangria</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function performWithdraw() {
    const amount = $('#withdrawAmount').val();
    const reason = $('#withdrawReason').val();

    if (!amount || !reason) {
        alert('Por favor, preencha todos os campos!');
        return;
    }

    $.ajax({
        url: '{{ route("cash-registers.withdraw") }}',
        method: 'POST',
        data: {
            amount: amount,
            reason: reason,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert(xhr.responseJSON.error || 'Erro ao realizar sangria');
        }
    });
}
</script>
@endpush 