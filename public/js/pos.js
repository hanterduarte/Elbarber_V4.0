// Inicialização das variáveis
let cart = [];
let subtotal = 0;
let total = 0;
let discountPercent = 0;
let discountValue = 0;
let paymentIndex = 1;

// Configuração do CSRF token para todas as requisições AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Event Listeners
$(document).ready(function() {
    // Adicionar item ao carrinho
    $('.add-item').click(function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const name = $(this).data('name');
        const price = $(this).data('price');
        const stock = type === 'product' ? $(this).data('stock') : null;
        const isActive = $(this).data('is-active');
        
        if (isActive === 0) {
            alert('Este item não está mais disponível.');
            return;
        }
        
        addToCart(id, type, name, price, stock);
    });

    // Busca de produtos e serviços
    $('#search').keyup(function() {
        const search = $(this).val().toLowerCase();
        $('.card').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).closest('.col-md-4').toggle(text.indexOf(search) > -1);
        });
    });

    // Cancelar venda
    $('#cancel-sale').click(function() {
        if (confirm('Tem certeza que deseja cancelar a venda?')) {
            cart = [];
            updateCart();
            $('#posForm')[0].reset();
            $('#payment-methods').html(`
                <div class="payment-method">
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select class="form-control payment-type" name="payments[0][method]" required>
                            <option value="cash">Dinheiro</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="debit_card">Cartão de Débito</option>
                            <option value="pix">PIX</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="number" class="form-control payment-amount" name="payments[0][amount]" step="0.01" required>
                    </div>
                </div>
            `);
            paymentIndex = 1;
        }
    });

    // Atalhos de função
    $('#btn-open-cashier').click(openCashier);
    $('#btn-cash-withdrawal').click(cashWithdrawal);
    $('#btn-cash-reinforcement').click(cashReinforcement);
    $('#btn-close-cashier').click(closeCashier);

    // Atalhos de teclado
    $(document).keydown(function(e) {
        // Evita ativar os atalhos se estiver em um campo de input
        if ($(e.target).is('input, textarea')) return;

        switch(e.key) {
            case 'F1':
                e.preventDefault();
                openCashier();
                break;
            case 'F2':
                e.preventDefault();
                cashWithdrawal();
                break;
            case 'F3':
                e.preventDefault();
                cashReinforcement();
                break;
            case 'F4':
                e.preventDefault();
                closeCashier();
                break;
        }
    });
});

// Função para adicionar item ao carrinho
function addToCart(id, type, name, price, stock = null) {
    const existingItem = cart.find(item => item.id === id && item.type === type);
    
    if (existingItem) {
        if (type === 'product' && stock !== null && existingItem.quantity >= stock) {
            alert('Quantidade máxima em estoque atingida!');
            return;
        }
        existingItem.quantity++;
    } else {
        cart.push({
            id: id,
            type: type,
            name: name,
            price: parseFloat(price),
            quantity: 1,
            stock: stock
        });
    }
    
    updateCart();
}

// Função para atualizar o carrinho
function updateCart() {
    const tbody = $('#cart tbody');
    tbody.empty();
    subtotal = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        tbody.append(`
            <tr>
                <td>${item.name}</td>
                <td>
                    <input type="number" class="form-control form-control-sm quantity" 
                        value="${item.quantity}" min="1" data-index="${index}" style="width: 70px">
                </td>
                <td class="text-right">R$ ${item.price.toFixed(2).replace('.', ',')}</td>
                <td class="text-right">R$ ${itemTotal.toFixed(2).replace('.', ',')}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
    });

    $('#subtotal').text(`R$ ${subtotal.toFixed(2).replace('.', ',')}`);
    updateTotal();
}

// Função para atualizar o total
function updateTotal() {
    discountPercent = parseFloat($('#discount_percent').val()) || 0;
    discountValue = parseFloat($('#discount_value').val()) || 0;
    
    if (discountValue > 0) {
        total = subtotal - discountValue;
        if (subtotal > 0) {
            const equivalentPercent = (discountValue / subtotal) * 100;
            $('#discount_percent').val(equivalentPercent.toFixed(2));
        }
    } else if (discountPercent > 0) {
        const discountAmount = (subtotal * discountPercent) / 100;
        total = subtotal - discountAmount;
        $('#discount_value').val(discountAmount.toFixed(2));
    } else {
        total = subtotal;
        $('#discount_value').val('0');
        $('#discount_percent').val('0');
    }

    total = Math.max(0, total);
    $('#total').text(`R$ ${total.toFixed(2).replace('.', ',')}`);
    
    // Atualiza o valor do primeiro campo de pagamento apenas se estiver vazio ou se o valor atual for menor que o total
    const firstPayment = $('.payment-amount').first();
    const currentValue = parseFloat(firstPayment.val()) || 0;
    if (currentValue === 0 || currentValue < total) {
        firstPayment.val(total.toFixed(2));
    }
    
    updateTroco();
}

// Função para calcular e atualizar o troco
function updateTroco() {
    const valorPago = parseFloat($('.payment-amount').first().val()) || 0;
    if (valorPago > total) {
        const troco = valorPago - total;
        $('#troco').text(`R$ ${troco.toFixed(2).replace('.', ',')}`);
    } else {
        $('#troco').text('R$ 0,00');
    }
}

// Event Listeners para alterações no carrinho
$(document).on('change', '.quantity', function() {
    const index = $(this).data('index');
    const quantity = parseInt($(this).val());

    if (quantity < 1) {
        $(this).val(1);
        cart[index].quantity = 1;
    } else {
        if (cart[index].type === 'product' && cart[index].stock !== null && quantity > cart[index].stock) {
            alert('Quantidade maior que o estoque disponível!');
            $(this).val(cart[index].stock);
            cart[index].quantity = cart[index].stock;
        } else {
            cart[index].quantity = quantity;
        }
    }

    updateCart();
});

$(document).on('click', '.remove-item', function() {
    const index = $(this).data('index');
    cart.splice(index, 1);
    updateCart();
});

// Event Listeners para descontos
$('#discount_percent').on('input', function() {
    const value = parseFloat($(this).val()) || 0;
    if (value < 0) $(this).val(0);
    if (value > 100) $(this).val(100);
    $('#discount_value').val('0');
    updateTotal();
});

$('#discount_value').on('input', function() {
    const value = parseFloat($(this).val()) || 0;
    if (value < 0) $(this).val(0);
    if (value > subtotal) $(this).val(subtotal);
    $('#discount_percent').val('0');
    updateTotal();
});

// Botão limpar desconto
$('#clear-discount').click(function() {
    $('#discount_percent').val('0');
    $('#discount_value').val('0');
    updateTotal();
});

// Event Listeners para formas de pagamento
$('#add-payment').click(function() {
    const newPayment = `
        <div class="payment-method">
            <hr>
            <div class="form-group">
                <label>Forma de Pagamento</label>
                <select class="form-control payment-type" name="payments[${paymentIndex}][method]" required>
                    <option value="cash">Dinheiro</option>
                    <option value="credit_card">Cartão de Crédito</option>
                    <option value="debit_card">Cartão de Débito</option>
                    <option value="pix">PIX</option>
                </select>
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" class="form-control payment-amount" name="payments[${paymentIndex}][amount]" step="0.01" min="0" required>
            </div>
        </div>
    `;
    $('#payment-methods').append(newPayment);
    paymentIndex++;
});

$(document).on('click', '.remove-payment', function() {
    $(this).closest('.payment-method').remove();
});

// Event listener para atualizar o troco quando o valor do pagamento mudar
$(document).on('input', '.payment-amount', function() {
    if ($(this).is(':first')) {
        updateTroco();
    }
});

// Submissão do formulário
$('#posForm').submit(function(e) {
    e.preventDefault();

    if (cart.length === 0) {
        alert('Adicione itens ao carrinho!');
        return;
    }

    let totalPayments = 0;
    let hasCashPayment = false;
    let cashAmount = 0;

    $('.payment-method').each(function() {
        const method = $(this).find('.payment-type').val();
        const amount = parseFloat($(this).find('.payment-amount').val()) || 0;
        
        if (method === 'cash') {
            hasCashPayment = true;
            cashAmount = amount;
        } else {
            totalPayments += amount;
        }
    });

    // Se tiver pagamento em dinheiro, adiciona apenas o valor necessário para completar o total
    if (hasCashPayment) {
        const remainingAmount = total - totalPayments;
        if (cashAmount < remainingAmount) {
            alert('O valor total dos pagamentos é menor que o total da venda!');
            return;
        }
        totalPayments += remainingAmount; // Considera apenas o valor necessário do dinheiro
    } else {
        // Se não tiver dinheiro, a soma deve ser exata
        if (Math.abs(totalPayments - total) > 0.01) {
            alert('A soma dos pagamentos deve ser igual ao total da venda!');
            return;
        }
    }

    const formData = {
        client_id: $('#client_id').val(),
        discount_percent: $('#discount_percent').val(),
        discount_value: $('#discount_value').val(),
        notes: $('#notes').val(),
        items: cart.map(item => ({
            id: item.id,
            type: item.type,
            quantity: item.quantity
        })),
        payments: []
    };

    $('.payment-method').each(function() {
        const method = $(this).find('.payment-type').val();
        const amount = parseFloat($(this).find('.payment-amount').val());
        
        // Se for pagamento em dinheiro e for maior que o necessário, ajusta para o valor exato
        if (method === 'cash' && amount > (total - totalPayments + amount)) {
            formData.payments.push({
                method: method,
                amount: total - totalPayments + amount
            });
        } else {
            formData.payments.push({
                method: method,
                amount: amount
            });
        }
    });

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        success: function(response) {
            alert('Venda realizada com sucesso!');
            cart = [];
            updateCart();
            $('#posForm')[0].reset();
            $('#payment-methods').html(`
                <div class="payment-method">
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select class="form-control payment-type" name="payments[0][method]" required>
                            <option value="cash">Dinheiro</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="debit_card">Cartão de Débito</option>
                            <option value="pix">PIX</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="number" class="form-control payment-amount" name="payments[0][amount]" step="0.01" required>
                    </div>
                </div>
            `);
            paymentIndex = 1;
        },
        error: function(xhr) {
            alert(xhr.responseJSON?.error || 'Erro ao processar a venda');
        }
    });
});

// Funções do caixa
function openCashier() {
    // Modal de abertura de caixa
    Swal.fire({
        title: 'Abertura de Caixa',
        html: `
            <div class="form-group">
                <label>Valor Inicial</label>
                <input type="number" id="initial-amount" class="form-control" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>Observações</label>
                <textarea id="opening-notes" class="form-control" rows="3"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Abrir Caixa',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                initial_amount: document.getElementById('initial-amount').value,
                notes: document.getElementById('opening-notes').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar dados para o servidor
            $.ajax({
                url: '/cash-registers/open',
                method: 'POST',
                data: result.value,
                success: function(response) {
                    Swal.fire('Sucesso!', 'Caixa aberto com sucesso!', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Erro!', xhr.responseJSON?.error || 'Erro ao abrir o caixa', 'error');
                }
            });
        }
    });
}

function cashWithdrawal() {
    // Modal de sangria
    Swal.fire({
        title: 'Sangria de Caixa',
        html: `
            <div class="form-group">
                <label>Valor</label>
                <input type="number" id="withdrawal-amount" class="form-control" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>Motivo</label>
                <textarea id="withdrawal-reason" class="form-control" rows="3"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Realizar Sangria',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                amount: document.getElementById('withdrawal-amount').value,
                reason: document.getElementById('withdrawal-reason').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar dados para o servidor
            $.ajax({
                url: '/cash-registers/withdraw',
                method: 'POST',
                data: result.value,
                success: function(response) {
                    Swal.fire('Sucesso!', 'Sangria realizada com sucesso!', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Erro!', xhr.responseJSON?.error || 'Erro ao realizar sangria', 'error');
                }
            });
        }
    });
}

function cashReinforcement() {
    // Modal de reforço
    Swal.fire({
        title: 'Reforço de Caixa',
        html: `
            <div class="form-group">
                <label>Valor</label>
                <input type="number" id="reinforcement-amount" class="form-control" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>Observações</label>
                <textarea id="reinforcement-notes" class="form-control" rows="3"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Realizar Reforço',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                amount: document.getElementById('reinforcement-amount').value,
                notes: document.getElementById('reinforcement-notes').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar dados para o servidor
            $.ajax({
                url: '/cash-registers/reinforcement',
                method: 'POST',
                data: result.value,
                success: function(response) {
                    Swal.fire('Sucesso!', 'Reforço realizado com sucesso!', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Erro!', xhr.responseJSON?.error || 'Erro ao realizar reforço', 'error');
                }
            });
        }
    });
}

function closeCashier() {
    // Modal de fechamento
    Swal.fire({
        title: 'Fechamento de Caixa',
        html: `
            <div class="form-group">
                <label>Valor em Caixa</label>
                <input type="number" id="closing-amount" class="form-control" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>Observações</label>
                <textarea id="closing-notes" class="form-control" rows="3"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Fechar Caixa',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                final_amount: document.getElementById('closing-amount').value,
                notes: document.getElementById('closing-notes').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar dados para o servidor
            $.ajax({
                url: '/cash-registers/close',
                method: 'POST',
                data: result.value,
                success: function(response) {
                    Swal.fire('Sucesso!', 'Caixa fechado com sucesso!', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Erro!', xhr.responseJSON?.error || 'Erro ao fechar o caixa', 'error');
                }
            });
        }
    });
} 