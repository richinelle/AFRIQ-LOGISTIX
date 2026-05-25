<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // [READ ALL] : Lister toutes les catégories
    public function index() {
        return response()->json(Category::all(), 200);
    }

    // [CREATE] : Créer une nouvelle catégorie
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return response()->json($category, 201);
    }

    // [READ ONE] : Voir une seule catégorie précise
    public function show(Category $category) {
        return response()->json($category, 200);
    }

    // [UPDATE] : Modifier une catégorie existante
    public function update(Request $request, Category $category) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $request->description,
        ]);

        return response()->json($category, 200);
    }

    // [DELETE] : Supprimer une catégorie
    public function destroy(Category $category) {
        $category->delete();
        return response()->json(['message' => 'Catégorie supprimée avec succès'], 200);
    }
}
