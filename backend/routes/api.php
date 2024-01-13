<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

//get all categories
Route::get('/categories', [CategoryController::class, 'index']);
//get all recipes
Route::get('/recipes', [RecipeController::class, 'index']);
//store a recipe
Route::post('/recipes', [RecipeController::class, 'store']);
//get single recipe
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);
//update a single recipe
Route::patch('/recipes/{recipe}', [RecipeController::class, 'update']);
//delete single recipe
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);

//upload api
Route::post('/recipes/upload', [RecipeController::class, 'upload']);
