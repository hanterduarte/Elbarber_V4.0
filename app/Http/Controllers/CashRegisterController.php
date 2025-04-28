<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashRegister;
use Carbon\Carbon;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentCashRegister = CashRegister::whereNull('closed_at')->first();
        $lastClosedCashRegister = CashRegister::whereNotNull('closed_at')
            ->orderBy('closed_at', 'desc')
            ->first();

        return view('cash-registers.index', compact('currentCashRegister', 'lastClosedCashRegister'));
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
        //
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

    public function open(Request $request)
    {
        $request->validate([
            'initial_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // Verifica se já existe um caixa aberto
        if (CashRegister::whereNull('closed_at')->exists()) {
            return redirect()->back()->with('error', 'Já existe um caixa aberto!');
        }

        $cashRegister = new CashRegister();
        $cashRegister->user_id = auth()->id();
        $cashRegister->initial_amount = $request->initial_amount;
        $cashRegister->cash_in = 0;
        $cashRegister->cash_out = 0;
        $cashRegister->card_total = 0;
        $cashRegister->pix_total = 0;
        $cashRegister->notes = $request->notes;
        $cashRegister->opened_at = now();
        $cashRegister->save();

        return redirect()->back()->with('success', 'Caixa aberto com sucesso!');
    }

    public function close(Request $request, CashRegister $cashRegister)
    {
        $request->validate([
            'final_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($cashRegister->closed_at) {
            return redirect()->back()->with('error', 'Este caixa já está fechado!');
        }

        $cashRegister->final_amount = $request->final_amount;
        $cashRegister->closed_by = auth()->id();
        $cashRegister->closed_at = now();
        $cashRegister->notes = $request->notes;
        $cashRegister->save();

        return redirect()->back()->with('success', 'Caixa fechado com sucesso!');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string'
        ]);

        $cashRegister = CashRegister::whereNull('closed_at')->first();

        if (!$cashRegister) {
            return response()->json(['error' => 'Não há caixa aberto!'], 400);
        }

        $totalCash = $cashRegister->initial_amount + $cashRegister->cash_in - $cashRegister->cash_out;

        if ($request->amount > $totalCash) {
            return response()->json(['error' => 'Valor da sangria maior que o disponível em caixa!'], 400);
        }

        $cashRegister->cash_out += $request->amount;
        $cashRegister->notes = $cashRegister->notes . "\nSangria: R$ " . number_format($request->amount, 2) . " - Motivo: " . $request->reason;
        $cashRegister->save();

        return response()->json(['message' => 'Sangria realizada com sucesso!']);
    }

    public function reinforcement(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string'
        ]);

        $cashRegister = CashRegister::whereNull('closed_at')->first();

        if (!$cashRegister) {
            return response()->json(['error' => 'Não há caixa aberto!'], 400);
        }

        $cashRegister->cash_in += $request->amount;
        $cashRegister->notes = $cashRegister->notes . "\nReforço: R$ " . number_format($request->amount, 2) . " - " . $request->notes;
        $cashRegister->save();

        return response()->json(['message' => 'Reforço realizado com sucesso!']);
    }
}
