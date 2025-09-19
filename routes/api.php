<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ProvinciaController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\AtractivoController;
use App\Http\Controllers\API\FuenteController;
use App\Http\Controllers\API\ContactoController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\ImagenController;

/**
 * @OA\Get(
 *     path="/api/test",
 *     summary="Test API connection",
 *     tags={"Test"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="API is working!")
 *         )
 *     )
 * )
 */
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

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

// Authentication routes are now documented in AuthController

// ====================
// PUBLIC ROUTES (READ)
// ====================

// Provincias
Route::apiResource('provincias', ProvinciaController::class)->only(['index', 'show']);

// Categorias
Route::get('categorias', [CategoriaController::class, 'index']);
Route::get('categorias/activas', [CategoriaController::class, 'activas']);
Route::get('categorias/{id}', [CategoriaController::class, 'show']);
Route::get('categorias/{id}/con-atractivos', [CategoriaController::class, 'withAtractivos']);

// Atractivos
Route::apiResource('atractivos', AtractivoController::class)->only(['index', 'show']);
Route::get('atractivos/provincia/{provinciaId}', [AtractivoController::class, 'byProvincia']);
Route::get('atractivos/categoria/{categoriaId}', [AtractivoController::class, 'byCategoria']);
Route::get('atractivos/search', [AtractivoController::class, 'search']);

// Tags
Route::get('tags', [TagController::class, 'index']);
Route::get('tags/{id}', [TagController::class, 'show']);

// Fuentes
Route::get('fuentes', [FuenteController::class, 'index']);
Route::get('fuentes/{id}', [FuenteController::class, 'show']);

// Contactos
Route::get('contactos', [ContactoController::class, 'index']);
Route::get('contactos/{id}', [ContactoController::class, 'show']);
Route::get('atractivos/{atractivoId}/contactos', [ContactoController::class, 'byAtractivo']);

// Imágenes
Route::get('imagenes', [ImagenController::class, 'index']);
Route::get('imagenes/{id}', [ImagenController::class, 'show']);
Route::get('atractivos/{atractivoId}/imagenes', [ImagenController::class, 'byAtractivo']);

// ====================
// AUTHENTICATION ROUTES
// ====================
Route::prefix('auth')->group(function () {
    // Public routes (no authentication required)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});

// ===========================
// PROTECTED ROUTES (WRITE)
// ===========================
Route::middleware('auth:sanctum')->group(function () {

    // Provincias
    Route::post('provincias', [ProvinciaController::class, 'store']);
    Route::put('provincias/{id}', [ProvinciaController::class, 'update']);
    Route::delete('provincias/{id}', [ProvinciaController::class, 'destroy']);

    // Categorias
    Route::post('categorias', [CategoriaController::class, 'store']);
    Route::put('categorias/{id}', [CategoriaController::class, 'update']);
    Route::delete('categorias/{id}', [CategoriaController::class, 'destroy']);

    // Atractivos
    Route::post('atractivos', [AtractivoController::class, 'store']);
    Route::put('atractivos/{id}', [AtractivoController::class, 'update']);
    Route::delete('atractivos/{id}', [AtractivoController::class, 'destroy']);

    // Fuentes
    Route::post('fuentes', [FuenteController::class, 'store']);
    Route::put('fuentes/{id}', [FuenteController::class, 'update']);
    Route::delete('fuentes/{id}', [FuenteController::class, 'destroy']);

    // Contactos
    Route::post('contactos', [ContactoController::class, 'store']);
    Route::put('contactos/{id}', [ContactoController::class, 'update']);
    Route::delete('contactos/{id}', [ContactoController::class, 'destroy']);

    // Tags
    Route::post('tags', [TagController::class, 'store']);
    Route::put('tags/{id}', [TagController::class, 'update']);
    Route::delete('tags/{id}', [TagController::class, 'destroy']);
    Route::post('atractivos/{atractivoId}/tags', [TagController::class, 'attachToAtractivo']);
    Route::delete('atractivos/{atractivoId}/tags/{tagId}', [TagController::class, 'detachFromAtractivo']);

    // Imágenes
    Route::post('imagenes', [ImagenController::class, 'store']);
    Route::put('imagenes/{id}', [ImagenController::class, 'update']);
    Route::delete('imagenes/{id}', [ImagenController::class, 'destroy']);
    Route::post('imagenes/{id}/set-principal', [ImagenController::class, 'setAsPrincipal']);
});
