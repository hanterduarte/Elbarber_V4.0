$(document).ready(function() {
    // Configuração do CSRF token para todas as requisições AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Inicializa o Select2 em todos os selects com a classe select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Inicializa máscaras de telefone
    $('input[name="phone"]').inputmask('(99) 99999-9999');

    // Inicializa máscaras de moeda
    $('input[name="price"]').inputmask('currency', {
        radixPoint: ',',
        groupSeparator: '.',
        allowMinus: false,
        prefix: '',
        digits: 2,
        digitsOptional: false,
        rightAlign: false,
        unmaskAsNumber: true
    });

    // Inicialização das máscaras de input
    if ($.fn.inputmask) {
        $('.money').inputmask('currency', {
            prefix: 'R$ ',
            radixPoint: ',',
            groupSeparator: '.',
            allowMinus: false,
            digits: 2,
            digitsOptional: false,
            rightAlign: false,
            unmaskAsNumber: true
        });

        $('.number').inputmask('numeric', {
            rightAlign: false
        });
    }

    // Função para formatar moeda
    function formatMoney(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }

    // Função para tratar erros de AJAX
    function handleAjaxError(xhr, textStatus, errorThrown) {
        console.error('Erro na requisição:', {xhr, textStatus, errorThrown});
        
        let errorMessage = 'Ocorreu um erro ao processar a solicitação.';
        
        if (xhr.responseJSON) {
            if (xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            // Log dos detalhes do erro
            console.error('Detalhes do erro:', xhr.responseJSON);
        }

        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: errorMessage
        });
    }

    // Manipuladores de eventos para o caixa
    $('#btn-open-cashier, .btn-open-cashier, [data-key="F1"]').on('click', function() {
        Swal.fire({
            title: 'Abertura de Caixa',
            html: `
                <div class="form-group">
                    <label>Valor Inicial</label>
                    <input type="text" id="initial-amount" class="form-control" placeholder="R$ 0,00">
                </div>
                <div class="form-group">
                    <label>Observações</label>
                    <textarea id="opening-notes" class="form-control" rows="3"></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Abrir Caixa',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                // Inicializa a máscara no input dentro do modal
                $('#initial-amount').inputmask('currency', {
                    prefix: 'R$ ',
                    radixPoint: ',',
                    groupSeparator: '.',
                    allowMinus: false,
                    digits: 2,
                    digitsOptional: false,
                    rightAlign: false,
                    unmaskAsNumber: true
                });
            },
            preConfirm: () => {
                const amount = $('#initial-amount').inputmask('unmaskedvalue') || 0;
                const notes = $('#opening-notes').val();

                if (!amount || amount <= 0) {
                    Swal.showValidationMessage('Por favor, informe um valor inicial válido');
                    return false;
                }

                return {
                    initial_amount: parseFloat(amount),
                    notes: notes
                };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                console.log('Enviando dados:', result.value);
                
                $.ajax({
                    url: '/cashier/open',
                    method: 'POST',
                    data: result.value,
                    success: function(response) {
                        console.log('Resposta do servidor:', response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: response.message
                        }).then(() => {
                            // Recarrega a página após o sucesso
                            window.location.reload();
                        });
                    },
                    error: handleAjaxError
                });
            }
        });
    });

    // Atalhos de teclado
    $(document).on('keydown', function(e) {
        // Não executa se estiver em um input ou textarea
        if ($(e.target).is('input, textarea')) return;

        switch(e.key) {
            case 'F1':
                e.preventDefault();
                $('#btn-open-cashier').click();
                break;
            case 'F2':
                e.preventDefault();
                $('#btn-cash-withdrawal').click();
                break;
            case 'F3':
                e.preventDefault();
                $('#btn-cash-reinforcement').click();
                break;
            case 'F4':
                e.preventDefault();
                $('#btn-close-cashier').click();
                break;
        }
    });
}); 