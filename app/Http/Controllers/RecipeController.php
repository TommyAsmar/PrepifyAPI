<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with('ingredients')->get();
        return response()->json($recipes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.1',
            'ingredients.*.unit' => 'required|string|max:50',
        ]);

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
        ]);

        foreach ($validated['ingredients'] as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }

        return response()->json($recipe->load('ingredients'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::with('ingredients')->findOrFail($id);
        return response()->json($recipe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        if ($recipe->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'ingredients' => 'nullable|array',
            'ingredients.*.id' => 'required_with:ingredients|exists:ingredients,id',
            'ingredients.*.quantity' => 'required_with:ingredients|numeric|min:0.1',
            'ingredients.*.unit' => 'required_with:ingredients|string|max:50',
        ]);

        $recipe->update([
            'title' => $validated['title'] ?? $recipe->title,
            'description' => $validated['description'] ?? $recipe->desc,
            'instructions' => $validated['instructions'] ?? $recipe->instructions,
        ]);

        if (isset($validated['ingredients'])) {
            $syncData = [];

            foreach ($validated['ingredients'] as $ingredient) {
                $syncData[$ingredient['id']] = [
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ];
            }

            $recipe->ingredients()->sync($syncData);
        }

        return response()->json($recipe->load('ingredients'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        if ($recipe->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe->ingredients()->detach();
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }
}
