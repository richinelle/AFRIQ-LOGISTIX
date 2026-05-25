<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // [READ ALL] Voir tous les produits avec leur catégorie
    public function index() {
        return response()->json(Product::with('category')->get(), 200);
    }

    // [CREATE] Ajouter un produit
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // Vérifie que la catégorie existe
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // [READ ONE] Voir un produit précis
    public function show(Product $product) {
        return response()->json($product->load('category'), 200);
    }

    // [UPDATE] Modifier un produit
    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json($product, 200);
    }

    // [DELETE] Supprimer un produit
    public function destroy(Product $product) {
        $product->delete();
        return response()->json(['message' => 'Produit supprimé'], 200);
    }
}
