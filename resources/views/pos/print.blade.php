<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprovante de Venda #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="text-center mb-3">
        <h2 style="margin: 0;">{{ config('app.name') }}</h2>
        <p>CNPJ: XX.XXX.XXX/0001-XX</p>
        <p>Rua Exemplo, 123 - Centro</p>
        <p>Telefone: (11) 1234-5678</p>
    </div>

    <div class="divider"></div>

    <div class="mb-3">
        <p><strong>Comprovante de Venda #{{ $sale->id }}</strong></p>
        <p>Data: {{ $sale->created_at->format('d/m/Y H:i:s') }}</p>
        @if($sale->client)
            <p>Cliente: {{ $sale->client->name }}</p>
        @endif
        <p>Vendedor: {{ $sale->user->name }}</p>
    </div>

    <div class="divider"></div>

    <table class="mb-3">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qtd</th>
                <th class="text-right">Valor Unit.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="mb-3">
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Desconto:</td>
            <td class="text-right">{{ $sale->discount }}%</td>
        </tr>
        <tr class="total">
            <td>Total:</td>
            <td class="text-right">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="mb-3">
        <p>Forma de Pagamento: 
            @switch($sale->payment_method)
                @case('money')
                    Dinheiro
                    @break
                @case('credit_card')
                    Cartão de Crédito
                    @break
                @case('debit_card')
                    Cartão de Débito
                    @break
                @case('pix')
                    PIX
                    @break
                @default
                    {{ $sale->payment_method }}
            @endswitch
        </p>
        @if($sale->payment_method === 'money')
            <p>Valor Recebido: R$ {{ number_format($sale->received_amount, 2, ',', '.') }}</p>
            <p>Troco: R$ {{ number_format($sale->change_amount, 2, ',', '.') }}</p>
        @endif
    </div>

    <div class="divider"></div>

    <div class="text-center mb-3">
        <p>Obrigado pela Preferência!</p>
        <p>{{ config('app.name') }} - Sempre o Melhor Atendimento</p>
    </div>

    <div class="no-print text-center">
        <button onclick="window.print()">Imprimir</button>
    </div>
</body>
</html> 