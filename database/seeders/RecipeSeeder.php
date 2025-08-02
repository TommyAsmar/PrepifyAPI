<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $allIngredients = Ingredient::all();

        $users->each(function ($user) use ($allIngredients) {
            Recipe::factory(10)->create([
                'user_id' => $user->id,
            ])->each(function ($recipe) use ($allIngredients) {
                // Pick 2–3 random ingredients for each recipe
                $ingredientsToAttach = $allIngredients->random(3);

                foreach ($ingredientsToAttach as $ingredient) {
                    $recipe->ingredients()->attach($ingredient->id, [
                        'quantity' => fake()->randomFloat(1, 0.1, 3),
                        'unit' => fake()->randomElement(['g', 'cups', 'tbsp', 'ml', 'pieces']),
                    ]);
                }
            });
        });
    }
}