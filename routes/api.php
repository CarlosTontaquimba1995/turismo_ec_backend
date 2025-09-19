<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ProvinciaController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\AtractivoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Public routes
Route::apiResource('provincias', ProvinciaController::class)->only(['index', 'show']);
Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::apiResource('atractivos', AtractivoController::class)->only(['index', 'show']);
Route::get('atractivos/provincia/{provinciaId}', [AtractivoController::class, 'byProvincia']);
Route::get('atractivos/categoria/{categoriaId}', [AtractivoController::class, 'byCategoria']);
Route::get('atractivos/search', [AtractivoController::class, 'search']);

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'user']);
    });
    
    // Protected API routes (write operations)
    Route::apiResource('provincias', ProvinciaController::class)->except(['index', 'show']);
    Route::apiResource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::apiResource('atractivos', AtractivoController::class)->except(['index', 'show']);
});
