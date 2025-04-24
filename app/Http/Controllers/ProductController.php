<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'initial_stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048', // máximo 2MB
            'barcode' => 'nullable|string|unique:products,barcode',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products', 'public');
            $validated['photo'] = $path;
        }

        if (!isset($validated['initial_stock'])) {
            $validated['initial_stock'] = $validated['stock'];
        }

        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'initial_stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048', // máximo 2MB
            'barcode' => 'nullable|string|unique:products,barcode,' . $id,
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            // Remove a foto antiga se existir
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            $path = $request->file('photo')->store('products', 'public');
            $validated['photo'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Remove a foto se existir
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
        
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
