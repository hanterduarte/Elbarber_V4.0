<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'complement' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'reference_point' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Converte o valor do checkbox para boolean
        $validated['is_active'] = (bool) $request->input('is_active', true);

        $client = Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::withTrashed()->findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email,' . $id,
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'complement' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'reference_point' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Converte o valor do checkbox para boolean
        $validated['is_active'] = (bool) $request->input('is_active', true);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        
        // Verifica se o cliente tem agendamentos ou vendas antes de excluir
        if ($client->appointments()->count() > 0 || $client->sales()->count() > 0) {
            return redirect()->route('clients.index')
                ->with('error', 'Não é possível excluir um cliente que possui agendamentos ou vendas.');
        }

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
