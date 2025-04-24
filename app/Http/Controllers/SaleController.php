<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Product;
use App\Models\Client;
use App\Models\CashRegister;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica se existe um caixa aberto
        $cashRegister = CashRegister::whereNull('closed_at')->first();
        if (!$cashRegister) {
            return response()->json(['error' => 'Não há caixa aberto. Por favor, abra o caixa antes de realizar vendas.'], 400);
        }

        // Valida os dados
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_value' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.type' => 'required|in:product,service',
            'items.*.quantity' => 'required|integer|min:1',
            'payments' => 'required|array|min:1',
            'payments.*.method' => 'required|in:cash,credit_card,debit_card,pix',
            'payments.*.amount' => 'required|numeric|min:0.01'
        ]);

        try {
            \DB::beginTransaction();

            // Cria a venda
            $sale = new Sale();
            $sale->client_id = $request->client_id;
            $sale->user_id = auth()->id();
            $sale->cash_register_id = $cashRegister->id;
            $sale->notes = $request->notes;
            $sale->total = 0;
            $sale->save();

            $subtotal = 0;

            // Processa os itens
            foreach ($request->items as $item) {
                if ($item['type'] === 'product') {
                    $product = Product::findOrFail($item['id']);
                    
                    // Verifica estoque
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Produto {$product->name} não possui estoque suficiente.");
                    }

                    // Atualiza estoque
                    $product->stock -= $item['quantity'];
                    $product->save();

                    // Cria o item da venda
                    $saleItem = $sale->items()->create([
                        'itemable_id' => $product->id,
                        'itemable_type' => Product::class,
                        'price' => $product->price,
                        'quantity' => $item['quantity'],
                        'total' => $product->price * $item['quantity']
                    ]);

                    $subtotal += $saleItem->total;
                } else {
                    $service = Service::findOrFail($item['id']);

                    // Cria o item da venda
                    $saleItem = $sale->items()->create([
                        'itemable_id' => $service->id,
                        'itemable_type' => Service::class,
                        'price' => $service->price,
                        'quantity' => $item['quantity'],
                        'total' => $service->price * $item['quantity']
                    ]);

                    $subtotal += $saleItem->total;
                }
            }

            // Calcula o desconto
            $discountAmount = 0;
            if ($request->filled('discount_value')) {
                $discountAmount = $request->discount_value;
                // Calcula o percentual equivalente
                $discountPercent = ($discountAmount / $subtotal) * 100;
            } else {
                $discountPercent = $request->discount_percent ?? 0;
                $discountAmount = ($subtotal * $discountPercent) / 100;
            }

            // Calcula o total
            $total = $subtotal - $discountAmount;

            // Valida o total dos pagamentos
            $totalPayments = array_sum(array_column($request->payments, 'amount'));
            if (abs($totalPayments - $total) > 0.01) {
                throw new \Exception('A soma dos pagamentos deve ser igual ao total da venda.');
            }

            // Atualiza o total da venda
            $sale->subtotal = $subtotal;
            $sale->discount = $discountPercent;
            $sale->total = $total;
            $sale->save();

            // Processa os pagamentos
            foreach ($request->payments as $payment) {
                // Registra o pagamento
                $sale->payments()->create([
                    'method' => $payment['method'],
                    'amount' => $payment['amount']
                ]);

                // Atualiza o caixa
                if ($payment['method'] === 'cash') {
                    $cashRegister->cash_in += $payment['amount'];
                } elseif (in_array($payment['method'], ['credit_card', 'debit_card'])) {
                    $cashRegister->card_total += $payment['amount'];
                } else {
                    $cashRegister->pix_total += $payment['amount'];
                }
            }
            $cashRegister->save();

            \DB::commit();

            return response()->json([
                'message' => 'Venda realizada com sucesso!',
                'sale' => $sale
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the PDV interface.
     */
    public function pdv()
    {
        $services = Service::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $clients = Client::all();
        return view('pos.index', compact('services', 'products', 'clients'));
    }

    public function processSale(Request $request)
    {
        return $this->store($request);
    }
}
