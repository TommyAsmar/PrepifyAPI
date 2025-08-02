<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    /** @use HasFactory<\Database\Factories\MealPlanFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealEntries()
    {
        return $this->hasMany(MealEntry::class);
    }

    public function recipes()
    {
        return $this->hasManyThrough(
            Recipe::class,
            MealEntry::class,
            'meal_plan_id',
            'id',
            'id',
            'recipe_id'
        );
    }
}
