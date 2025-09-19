<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Categoria\UpdateCategoriaRequest;
use App\Http\Responses\ApiResponse;
use App\Services\CategoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Categories",
 *     description="API Endpoints for managing categories"
 * )
 * 
 * @OA\Schema(
 *     schema="Categoria",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Aventura"),
 *     @OA\Property(property="descripcion", type="string", example="Actividades de aventura y deportes extremos"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CategoriaController extends Controller
{
    protected CategoriaService $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Categoria")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $categorias = $this->categoriaService->getAll();
            return ApiResponse::success($categorias, 'Categories retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve categories.');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categorias",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Aventura"),
     *             @OA\Property(property="descripcion", type="string", example="Actividades de aventura y deportes extremos"),
     *             @OA\Property(property="estado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            $validated = $request->validated();
            $categoria = $this->categoriaService->create($validated);

            return ApiResponse::created($categoria, 'Category created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return ApiResponse::error('Failed to create category.');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categorias/{id}",
     *     summary="Get a specific category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category details",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function show(int $id)
    {
        try {
            $categoria = $this->categoriaService->find($id);

            if (is_null($categoria)) {
                return ApiResponse::notFound('Category not found.');
            }

            return ApiResponse::success($categoria, 'Category retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching category: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve category.');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/categorias/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Aventura Actualizada"),
     *             @OA\Property(property="descripcion", type="string", example="Nueva descripción"),
     *             @OA\Property(property="estado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateCategoriaRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $categoria = $this->categoriaService->update($id, $validated);

            if (is_null($categoria)) {
                return ApiResponse::notFound('Category not found.');
            }

            return ApiResponse::success($categoria, 'Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return ApiResponse::error('Failed to update category.');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categorias/{id}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function destroy(int $id)
    {
        try {
            $deleted = $this->categoriaService->delete($id);

            if (!$deleted) {
                return ApiResponse::notFound('Category not found.');
            }

            return ApiResponse::noContent();
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete category.');
        }
    }

    /**
     * Get all active categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activas()
    {
        try {
            $categorias = $this->categoriaService->getActiveCategorias();
            return ApiResponse::success($categorias, 'Active categories retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching active categories: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve active categories.');
        }
    }

    /**
     * Get a category with its attractions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function withAtractivos(int $id)
    {
        try {
            $categoria = $this->categoriaService->getCategoriaWithAtractivos($id);

            if (is_null($categoria)) {
                return ApiResponse::notFound('Category not found.');
            }

            return ApiResponse::success($categoria, 'Category with attractions retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching category with attractions: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve category with attractions.');
        }
    }
}
