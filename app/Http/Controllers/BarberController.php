<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BarberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barbers = Barber::with('user')->paginate(10);
        return view('barbers.index', compact('barbers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barbers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048' // máximo 2MB
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está em uso',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'commission_rate.numeric' => 'A comissão deve ser um número',
            'commission_rate.min' => 'A comissão não pode ser negativa',
            'commission_rate.max' => 'A comissão não pode ser maior que 100%',
            'photo.image' => 'O arquivo deve ser uma imagem',
            'photo.max' => 'A imagem não pode ser maior que 2MB'
        ]);

        try {
            \DB::beginTransaction();

            // Criar o usuário
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => isset($validated['is_active'])
            ]);

            // Upload da foto se existir
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('barbers', 'public');
            }

            // Criar o barbeiro
            $barber = Barber::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'] ?? null,
                'commission_rate' => $validated['commission_rate'] ?? 0,
                'bio' => $validated['bio'] ?? null,
                'is_active' => isset($validated['is_active']),
                'photo' => $photoPath
            ]);

            \DB::commit();

            return redirect()->route('barbers.index')
                ->with('success', 'Barbeiro cadastrado com sucesso!');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            return back()->with('error', 'Erro ao cadastrar barbeiro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barber = Barber::with(['user', 'appointments.client', 'appointments.service'])->findOrFail($id);
        return view('barbers.show', compact('barber'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barber = Barber::with('user')->findOrFail($id);
        return view('barbers.edit', compact('barber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barber = Barber::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $barber->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048'
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está em uso',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'commission_rate.numeric' => 'A comissão deve ser um número',
            'commission_rate.min' => 'A comissão não pode ser negativa',
            'commission_rate.max' => 'A comissão não pode ser maior que 100%',
            'photo.image' => 'O arquivo deve ser uma imagem',
            'photo.max' => 'A imagem não pode ser maior que 2MB'
        ]);

        try {
            \DB::beginTransaction();

            // Atualizar usuário
            $barber->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_active' => isset($validated['is_active'])
            ]);

            if (!empty($validated['password'])) {
                $barber->user->update([
                    'password' => Hash::make($validated['password'])
                ]);
            }

            // Upload da nova foto se existir
            if ($request->hasFile('photo')) {
                // Deletar foto antiga se existir
                if ($barber->photo) {
                    Storage::disk('public')->delete($barber->photo);
                }
                $photoPath = $request->file('photo')->store('barbers', 'public');
                $validated['photo'] = $photoPath;
            }

            // Atualizar barbeiro
            $barber->update([
                'phone' => $validated['phone'] ?? null,
                'commission_rate' => $validated['commission_rate'] ?? 0,
                'bio' => $validated['bio'] ?? null,
                'is_active' => isset($validated['is_active']),
                'photo' => $validated['photo'] ?? $barber->photo
            ]);

            \DB::commit();

            return redirect()->route('barbers.index')
                ->with('success', 'Barbeiro atualizado com sucesso!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Erro ao atualizar barbeiro: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barber = Barber::findOrFail($id);
        
        try {
            \DB::beginTransaction();

            // Deletar foto se existir
            if ($barber->photo) {
                Storage::disk('public')->delete($barber->photo);
            }

            // Deletar usuário e barbeiro
            $barber->user->delete();
            $barber->delete();

            \DB::commit();

            return redirect()->route('barbers.index')
                ->with('success', 'Barbeiro excluído com sucesso!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Erro ao excluir barbeiro: ' . $e->getMessage());
        }
    }
}
