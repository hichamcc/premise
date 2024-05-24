<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DietPlanController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/questionnaire', [QuestionnaireController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('questionnaire');

Route::get('/diets', [DashboardController::class, 'diets'])
    ->middleware(['auth', 'verified'])
    ->name('diets');

Route::get('/workouts', [DashboardController::class, 'workouts'])
    ->middleware(['auth', 'verified'])
    ->name('workouts');

Route::get('/generate-diet-plans', [DietPlanController::class, 'generateDietPlans'])
    ->middleware(['auth', 'verified'])
    ->name('generate.diet.plans');

require __DIR__.'/auth.php';
