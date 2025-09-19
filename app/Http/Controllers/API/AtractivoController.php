<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Atractivo\StoreAtractivoRequest;
use App\Http\Requests\Atractivo\UpdateAtractivoRequest;
use App\Http\Responses\ApiResponse;
use App\Services\AtractivoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Attractions",
 *     description="API Endpoints for managing tourist attractions"
 * )
 * 
 * @OA\Schema(
 *     schema="Atractivo",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Volcán Cotopaxi"),
 *     @OA\Property(property="descripcion", type="string", example="Uno de los volcanes activos más altos del mundo"),
 *     @OA\Property(property="direccion", type="string", example="Parque Nacional Cotopaxi"),
 *     @OA\Property(property="latitud", type="number", format="float", example="-0.6836"),
 *     @OA\Property(property="longitud", type="number", format="float", example="-78.4372"),
 *     @OA\Property(property="horario_visitas", type="string", example="08:00 - 17:00"),
 *     @OA\Property(property="precio_entrada", type="number", format="float", example=10.50),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="categoria_id", type="integer", example=1),
 *     @OA\Property(property="provincia_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class AtractivoController extends Controller
{
    protected $atractivoService;

    public function __construct(AtractivoService $atractivoService)
    {
        $this->atractivoService = $atractivoService;
    }

    /**
     * @OA\Get(
     *     path="/api/atractivos",
     *     summary="Get all active attractions",
     *     tags={"Attractions"},
     *     @OA\Response(
     *         response=200,
     *         description="List of active attractions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Atractivo")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $atractivos = $this->atractivoService->getActiveAtractivos();
        return ApiResponse::success($atractivos, 'Atractivos retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/api/atractivos",
     *     summary="Create a new attraction",
     *     tags={"Attractions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "categoria_id", "provincia_id"},
     *             @OA\Property(property="nombre", type="string", example="Volcán Cotopaxi"),
     *             @OA\Property(property="descripcion", type="string", example="Uno de los volcanes activos más altos del mundo"),
     *             @OA\Property(property="direccion", type="string", example="Parque Nacional Cotopaxi"),
     *             @OA\Property(property="latitud", type="number", format="float", example="-0.6836"),
     *             @OA\Property(property="longitud", type="number", format="float", example="-78.4372"),
     *             @OA\Property(property="horario_visitas", type="string", example="08:00 - 17:00"),
     *             @OA\Property(property="precio_entrada", type="number", format="float", example=10.50),
     *             @OA\Property(property="estado", type="boolean", example=true),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="provincia_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Attraction created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Atractivo")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreAtractivoRequest $request)
    {
        try {
            $atractivo = $this->atractivoService->create($request->validated());
            return ApiResponse::created($atractivo, 'Atractivo created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating atractivo: ' . $e->getMessage());
            return ApiResponse::error('Failed to create atractivo.');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/atractivos/{id}",
     *     summary="Get a specific attraction",
     *     tags={"Attractions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Attraction ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attraction details",
     *         @OA\JsonContent(ref="#/components/schemas/Atractivo")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attraction not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $atractivo = $this->atractivoService->findById($id);

            if (is_null($atractivo)) {
                return ApiResponse::notFound('Atractivo not found.');
            }

            return ApiResponse::success($atractivo, 'Atractivo retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching atractivo: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve atractivo.');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/atractivos/{id}",
     *     summary="Update an attraction",
     *     tags={"Attractions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Attraction ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Volcán Cotopaxi Actualizado"),
     *             @OA\Property(property="descripcion", type="string", example="Nueva descripción actualizada"),
     *             @OA\Property(property="direccion", type="string", example="Nueva dirección"),
     *             @OA\Property(property="latitud", type="number", format="float", example="-0.6836"),
     *             @OA\Property(property="longitud", type="number", format="float", example="-78.4372"),
     *             @OA\Property(property="horario_visitas", type="string", example="09:00 - 18:00"),
     *             @OA\Property(property="precio_entrada", type="number", format="float", example=15.00),
     *             @OA\Property(property="estado", type="boolean", example=true),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="provincia_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attraction updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Atractivo")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attraction not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateAtractivoRequest $request, $id)
    {
        try {
            $atractivo = $this->atractivoService->findById($id);

            if (is_null($atractivo)) {
                return ApiResponse::notFound('Atractivo not found.');
            }

            $this->atractivoService->update($atractivo->id, $request->validated());
            $atractivo = $this->atractivoService->findById($id);

            return ApiResponse::success($atractivo, 'Atractivo updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating atractivo: ' . $e->getMessage());
            return ApiResponse::error('Failed to update atractivo.');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/atractivos/{id}",
     *     summary="Delete an attraction",
     *     tags={"Attractions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Attraction ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attraction deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attraction not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $atractivo = $this->atractivoService->findById($id);

            if (is_null($atractivo)) {
                return ApiResponse::notFound('Atractivo not found.');
            }

            $this->atractivoService->deleteById($atractivo->id);
            return ApiResponse::noContent();
        } catch (\Exception $e) {
            Log::error('Error deleting atractivo: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete atractivo.');
        }
    }

    /**
     * Get atractivos by provincia.
     *
     * @param  int  $provinciaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byProvincia($provinciaId)
    {
        try {
            $atractivos = $this->atractivoService->getAtractivosByProvincia($provinciaId);
            return ApiResponse::success($atractivos, 'Atractivos by provincia retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching atractivos by provincia: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve atractivos by provincia.');
        }
    }

    /**
     * Get atractivos by categoria.
     *
     * @param  int  $categoriaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byCategoria($categoriaId)
    {
        try {
            $atractivos = $this->atractivoService->getAtractivosByCategoria($categoriaId);
            return ApiResponse::success($atractivos, 'Atractivos by categoria retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching atractivos by categoria: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve atractivos by categoria.');
        }
    }

    /**
     * Search atractivos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q');

            if (empty($query)) {
                return ApiResponse::error('Search query is required.');
            }

            $atractivos = $this->atractivoService->searchAtractivos($query);
            return ApiResponse::success($atractivos, 'Search results retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error searching atractivos: ' . $e->getMessage());
            return ApiResponse::error('Failed to search atractivos.');
        }
    }
}
