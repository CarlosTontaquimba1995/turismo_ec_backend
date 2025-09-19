<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provincia\StoreProvinciaRequest;
use App\Http\Requests\Provincia\UpdateProvinciaRequest;
use App\Http\Responses\ApiResponse;
use App\Services\ProvinciaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Provinces",
 *     description="API Endpoints for managing provinces"
 * )
 * 
 * @OA\Schema(
 *     schema="Provincia",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Pichincha"),
 *     @OA\Property(property="codigo_iso", type="string", example="P"),
 *     @OA\Property(property="region", type="string", example="Sierra"),
 *     @OA\Property(property="poblacion", type="integer", example=3000000),
 *     @OA\Property(property="superficie", type="number", format="float", example=9416.0),
 *     @OA\Property(property="capital", type="string", example="Quito"),
 *     @OA\Property(property="idioma_principal", type="string", example="Español"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ProvinciaController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected $provinciaService;

    public function __construct(ProvinciaService $provinciaService)
    {
        $this->provinciaService = $provinciaService;
    }

    /**
     * @OA\Get(
     *     path="/api/provincias",
     *     summary="Get all provinces",
     *     tags={"Provinces"},
     *     @OA\Response(
     *         response=200,
     *         description="List of provinces",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Provincia")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $provincias = $this->provinciaService->getActiveProvincias();
            return ApiResponse::success($provincias, 'Lista de provincias obtenida exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al obtener provincias: ' . $e->getMessage());
            return ApiResponse::error('Error al obtener la lista de provincias');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/provincias/{id}",
     *     summary="Get a specific province",
     *     tags={"Provincias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Province ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Province details",
     *         @OA\JsonContent(ref="#/components/schemas/Provincia")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Province not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $provincia = $this->provinciaService->getProvinciaWithAtractivos($id);

            if (is_null($provincia)) {
                return ApiResponse::notFound('Provincia no encontrada');
            }

            return ApiResponse::success($provincia, 'Provincia obtenida exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al obtener provincia: ' . $e->getMessage());
            return ApiResponse::error('Error al obtener la provincia');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/provincias",
     *     summary="Create a new province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "codigo_iso", "region"},
     *             @OA\Property(property="nombre", type="string", example="Pichincha"),
     *             @OA\Property(property="codigo_iso", type="string", example="P"),
     *             @OA\Property(property="region", type="string", example="Sierra"),
     *             @OA\Property(property="poblacion", type="integer", example=3000000),
     *             @OA\Property(property="superficie", type="number", format="float", example=9416.0),
     *             @OA\Property(property="capital", type="string", example="Quito"),
     *             @OA\Property(property="idioma_principal", type="string", example="Español"),
     *             @OA\Property(property="estado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Province created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Provincia")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreProvinciaRequest $request): JsonResponse
    {
        try {
            $provincia = $this->provinciaService->createProvincia($request->validated());
            return ApiResponse::success($provincia, 'Provincia creada exitosamente', 201);
        } catch (\Exception $e) {
            Log::error('Error al crear provincia: ' . $e->getMessage());
            return ApiResponse::error('Error al crear la provincia');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/provincias/{id}",
     *     summary="Update a province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Province ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Pichincha Actualizada"),
     *             @OA\Property(property="codigo_iso", type="string", example="P"),
     *             @OA\Property(property="region", type="string", example="Sierra"),
     *             @OA\Property(property="poblacion", type="integer", example=3200000),
     *             @OA\Property(property="superficie", type="number", format="float", example=9416.0),
     *             @OA\Property(property="capital", type="string", example="Quito"),
     *             @OA\Property(property="idioma_principal", type="string", example="Español, Kichwa"),
     *             @OA\Property(property="estado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Province updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Provincia")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Province not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateProvinciaRequest $request, int $id): JsonResponse
    {
        try {
            $provincia = $this->provinciaService->updateProvincia($id, $request->validated());

            if (is_null($provincia)) {
                return ApiResponse::notFound('Provincia no encontrada');
            }

            return ApiResponse::success($provincia, 'Provincia actualizada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar provincia: ' . $e->getMessage());
            return ApiResponse::error('Error al actualizar la provincia');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/provincias/{id}",
     *     summary="Delete a province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Province ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Province deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Province not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->provinciaService->deleteProvincia($id);

            if (!$success) {
                return ApiResponse::notFound('Provincia no encontrada');
            }

            return ApiResponse::noContent();
        } catch (\Exception $e) {
            Log::error('Error al eliminar provincia: ' . $e->getMessage());
            return ApiResponse::error('Error al eliminar la provincia');
        }
    }
}
