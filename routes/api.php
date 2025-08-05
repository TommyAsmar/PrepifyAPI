<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

//Meal Plans
Route::get('/meal-plans', [MealPlanController::class, 'index']);
Route::get('meal-plans/{id}', [MealPlanController::class, 'show']);
Route::post('/meal-plans', [MealPlanController::class, 'store']);
Route::put('/meal-plans/{id}', [MealPlanController::class, 'update']);
Route::delete('meal-plans/{id}', [MealPlanController::class, 'destroy']);

//Ingredients
Route::get('/ingredients', [IngredientController::class, 'index']);
Route::get('ingredients/{id}', [IngredientController::class, 'show']);
Route::post('/ingredients', [IngredientController::class, 'store']);
Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
Route::delete('ingredients/{id}', [IngredientController::class, 'destroy']);




