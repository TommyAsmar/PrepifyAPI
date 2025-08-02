<?php

namespace Database\Seeders;

use App\Models\MealPlan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $users->each(function ($user) {
            MealPlan::factory(rand(1, 2))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
