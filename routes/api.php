<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealEntryController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Recipes
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);

    // Meal Plans
    Route::post('/meal-plans', [MealPlanController::class, 'store']);
    Route::put('/meal-plans/{id}', [MealPlanController::class, 'update']);
    Route::delete('/meal-plans/{id}', [MealPlanController::class, 'destroy']);

    // Meal Entries
    Route::post('/meal-entries', [MealEntryController::class, 'store']);
    Route::put('/meal-entries/{id}', [MealEntryController::class, 'update']);
    Route::delete('/meal-entries/{id}', [MealEntryController::class, 'destroy']);
});

// Public Routes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);

Route::get('/ingredients', [IngredientController::class, 'index']);
Route::get('/ingredients/{id}', [IngredientController::class, 'show']);
Route::post('/ingredients', [IngredientController::class, 'store']);
Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']);

Route::get('/meal-plans', [MealPlanController::class, 'index']);
Route::get('/meal-plans/{id}', [MealPlanController::class, 'show']);

Route::get('/meal-entries', [MealEntryController::class, 'index']);
Route::get('/meal-entries/{id}', [MealEntryController::class, 'show']);


