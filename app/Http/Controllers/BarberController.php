<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\User;

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
        $users = User::whereDoesntHave('barber')->get();
        return view('barbers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:barbers,user_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'bio' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $barber = Barber::create($validated);

        return redirect()->route('barbers.index')
            ->with('success', 'Barbeiro cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barber = Barber::with('user')->findOrFail($id);
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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'bio' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $barber->update($validated);

        return redirect()->route('barbers.index')
            ->with('success', 'Barbeiro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barber = Barber::findOrFail($id);
        $barber->delete();

        return redirect()->route('barbers.index')
            ->with('success', 'Barbeiro excluído com sucesso!');
    }
}
