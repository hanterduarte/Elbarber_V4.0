$(document).ready(function() {
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
}); 