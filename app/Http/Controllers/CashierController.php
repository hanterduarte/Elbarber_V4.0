<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashierMovement;
use App\Models\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CashierController extends Controller
{
    public function open(Request $request)
    {
        try {
            Log::info('Tentativa de abertura de caixa', ['request' => $request->all()]);

            $validated = $request->validate([
                'initial_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:500'
            ]);

            Log::info('Dados validados', ['validated' => $validated]);

            // Verifica se já existe um caixa aberto
            $openCashier = Cashier::where('status', 'open')->first();
            if ($openCashier) {
                return response()->json(['error' => 'Já existe um caixa aberto!'], 422);
            }

            DB::beginTransaction();

            try {
                // Cria o registro do caixa
                $cashier = Cashier::create([
                    'opening_date' => Carbon::now(),
                    'opening_amount' => $request->initial_amount,
                    'current_amount' => $request->initial_amount,
                    'status' => 'open',
                    'opening_notes' => $request->notes,
                    'user_id' => auth()->id()
                ]);

                Log::info('Caixa criado', ['cashier' => $cashier]);

                // Registra o movimento de abertura
                $movement = CashierMovement::create([
                    'cashier_id' => $cashier->id,
                    'type' => 'opening',
                    'amount' => $request->initial_amount,
                    'notes' => $request->notes,
                    'user_id' => auth()->id()
                ]);

                Log::info('Movimento registrado', ['movement' => $movement]);

                DB::commit();
                return response()->json(['message' => 'Caixa aberto com sucesso!']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro na transação do banco', [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Erro ao abrir o caixa', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json([
                'error' => 'Erro ao abrir o caixa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function withdrawal(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0',
                'reason' => 'required|string|max:500'
            ]);

            // Verifica se existe um caixa aberto
            $cashier = Cashier::where('status', 'open')->first();
            if (!$cashier) {
                return response()->json(['error' => 'Não há caixa aberto!'], 422);
            }

            // Verifica se há saldo suficiente
            if ($cashier->current_amount < $request->amount) {
                return response()->json(['error' => 'Saldo insuficiente para realizar a sangria!'], 422);
            }

            DB::beginTransaction();

            // Atualiza o saldo do caixa
            $cashier->current_amount -= $request->amount;
            $cashier->save();

            // Registra o movimento de sangria
            CashierMovement::create([
                'cashier_id' => $cashier->id,
                'type' => 'withdrawal',
                'amount' => -$request->amount,
                'notes' => $request->reason,
                'user_id' => auth()->id()
            ]);

            DB::commit();
            return response()->json(['message' => 'Sangria realizada com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao realizar sangria: ' . $e->getMessage()], 500);
        }
    }

    public function reinforcement(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:500'
            ]);

            // Verifica se existe um caixa aberto
            $cashier = Cashier::where('status', 'open')->first();
            if (!$cashier) {
                return response()->json(['error' => 'Não há caixa aberto!'], 422);
            }

            DB::beginTransaction();

            // Atualiza o saldo do caixa
            $cashier->current_amount += $request->amount;
            $cashier->save();

            // Registra o movimento de reforço
            CashierMovement::create([
                'cashier_id' => $cashier->id,
                'type' => 'reinforcement',
                'amount' => $request->amount,
                'notes' => $request->notes,
                'user_id' => auth()->id()
            ]);

            DB::commit();
            return response()->json(['message' => 'Reforço realizado com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao realizar reforço: ' . $e->getMessage()], 500);
        }
    }

    public function close(Request $request)
    {
        try {
            $request->validate([
                'closing_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:500'
            ]);

            // Verifica se existe um caixa aberto
            $cashier = Cashier::where('status', 'open')->first();
            if (!$cashier) {
                return response()->json(['error' => 'Não há caixa aberto!'], 422);
            }

            DB::beginTransaction();

            // Calcula a diferença entre o valor informado e o valor esperado
            $difference = $request->closing_amount - $cashier->current_amount;

            // Atualiza o registro do caixa
            $cashier->update([
                'closing_date' => Carbon::now(),
                'closing_amount' => $request->closing_amount,
                'difference_amount' => $difference,
                'closing_notes' => $request->notes,
                'status' => 'closed'
            ]);

            // Registra o movimento de fechamento
            CashierMovement::create([
                'cashier_id' => $cashier->id,
                'type' => 'closing',
                'amount' => 0,
                'notes' => "Fechamento de caixa. Diferença: R$ " . number_format($difference, 2, ',', '.'),
                'user_id' => auth()->id()
            ]);

            DB::commit();
            return response()->json(['message' => 'Caixa fechado com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao fechar o caixa: ' . $e->getMessage()], 500);
        }
    }
} 