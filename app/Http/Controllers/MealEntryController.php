<?php

namespace App\Http\Controllers;

use App\Models\MealEntry;
use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealEntryController extends Controller
{
    // List all entries (optional)
    public function index()
    {
        $entries = MealEntry::with(['mealPlan', 'recipe'])->get();
        return response()->json($entries);
    }

    // Show a single entry
    public function show($id)
    {
        $entry = MealEntry::with(['mealPlan', 'recipe'])->findOrFail($id);
        return response()->json($entry);
    }

    // Create a new meal entry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'recipe_id' => 'required|exists:recipes,id',
            'day_of_week' => 'required|string',
            'meal_type' => 'required|string',
        ]);

        $mealPlan = MealPlan::findOrFail($validated['meal_plan_id']);

        if ($mealPlan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $entry = MealEntry::create($validated);
        return response()->json($entry, 201);
    }

    // Update a meal entry
    public function update(Request $request, $id)
    {
        $entry = MealEntry::findOrFail($id);

        if ($entry->mealPlan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'recipe_id' => 'sometimes|exists:recipes,id',
            'day_of_week' => 'sometimes|string',
            'meal_type' => 'sometimes|string',
        ]);

        $entry->update($validated);
        return response()->json($entry);
    }

    // Delete a meal entry
    public function destroy($id)
    {
        $entry = MealEntry::findOrFail($id);

        if ($entry->mealPlan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $entry->delete();
        return response()->json(['message' => 'Meal entry deleted']);
    }
}