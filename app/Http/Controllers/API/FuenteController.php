<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fuente\StoreFuenteRequest;
use App\Http\Requests\Fuente\UpdateFuenteRequest;
use App\Http\Responses\ApiResponse;
use App\Services\FuenteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FuenteController extends Controller
{
    protected $fuenteService;

    public function __construct(FuenteService $fuenteService)
    {
        $this->fuenteService = $fuenteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $fuentes = $this->fuenteService->getAllFuentes();
            return ApiResponse::success($fuentes, 'Fuentes retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching fuentes: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve fuentes.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Fuente\StoreFuenteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFuenteRequest $request): JsonResponse
    {
        try {
            $fuente = $this->fuenteService->createFuente($request->validated());
            return ApiResponse::created($fuente, 'Fuente created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating fuente: ' . $e->getMessage());
            return ApiResponse::error('Failed to create fuente.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $fuente = $this->fuenteService->getFuente($id);
            return ApiResponse::success($fuente, 'Fuente retrieved successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Fuente not found.');
        } catch (\Exception $e) {
            Log::error('Error fetching fuente: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve fuente.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Fuente\UpdateFuenteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFuenteRequest $request, int $id): JsonResponse
    {
        try {
            $fuente = $this->fuenteService->updateFuente($id, $request->validated());
            return ApiResponse::success($fuente, 'Fuente updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Fuente not found.');
        } catch (\Exception $e) {
            Log::error('Error updating fuente: ' . $e->getMessage());
            return ApiResponse::error('Failed to update fuente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->fuenteService->deleteFuente($id);
            return ApiResponse::noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Fuente not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting fuente: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete fuente.');
        }
    }
}
