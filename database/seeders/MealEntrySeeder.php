<?php

namespace Database\Seeders;

use App\Models\MealEntry;
use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mealTypes = ['Breakfast', 'Lunch', 'Snack', 'Dinner'];

        // Get all meal plans
        $mealPlans = MealPlan::all();

        foreach ($mealPlans as $plan) {
            // Get 4 unique recipes for the user who owns the plan
            $recipes = Recipe::where('user_id', $plan->user_id)->inRandomOrder()->take(4)->get();

            foreach ($mealTypes as $index => $type) {
                MealEntry::factory()->create([
                    'meal_plan_id' => $plan->id,
                    'recipe_id' => $recipes[$index]->id ?? null,
                    'meal_type' => $type,
                ]);
            }
        }
    }
}
