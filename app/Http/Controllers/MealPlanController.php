<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealPlanController extends Controller
{
    public function index()
    {
        return MealPlan::with('mealEntries')->get();
    }

    public function show($id)
    {
        $mealPlan = MealPlan::with(['mealEntries', 'recipes'])->findOrFail($id);
        return response()->json($mealPlan);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $mealPlan = MealPlan::create([
            'user_id' => Auth::id(),
            'title' => $attributes['title'],
            'description' => $attributes['description'] ?? null
        ]);

        return response()->json($mealPlan, 201);
    }

    public function update(Request $request, $id)
    {
        $mealPlan = MealPlan::findOrFail($id);

        if ($mealPlan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $attributes = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $mealPlan->update($attributes);
        return response()->json($mealPlan, 200);
    }

    public function destroy($id)
    {
        $mealPlan = MealPlan::findOrFail($id);

        if ($mealPlan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $mealPlan->delete();
        return response()->json(['message' => 'Meal plan deleted successfully'], 200);
    }
}
