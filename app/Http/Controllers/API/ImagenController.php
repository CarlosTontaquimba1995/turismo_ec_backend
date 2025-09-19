<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Imagen\SetPrincipalRequest;
use App\Http\Requests\Imagen\StoreImagenRequest;
use App\Http\Requests\Imagen\UpdateImagenRequest;
use App\Http\Responses\ApiResponse;
use App\Services\ImagenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ImagenController extends Controller
{
    protected $imagenService;

    public function __construct(ImagenService $imagenService)
    {
        $this->imagenService = $imagenService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $atractivoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $atractivoId): JsonResponse
    {
        try {
            $imagenes = $this->imagenService->getByAtractivo($atractivoId);
            return ApiResponse::success($imagenes, 'Imágenes retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching imágenes: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve imágenes.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Imagen\StoreImagenRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreImagenRequest $request): JsonResponse
    {
        try {
            $imagen = $this->imagenService->createImagen($request->validated());
            return ApiResponse::created($imagen, 'Imagen created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating imagen: ' . $e->getMessage());
            return ApiResponse::error('Failed to create imagen.');
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
            $imagen = $this->imagenService->getImagen($id);
            return ApiResponse::success($imagen, 'Imagen retrieved successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Imagen not found.');
        } catch (\Exception $e) {
            Log::error('Error fetching imagen: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve imagen.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Imagen\UpdateImagenRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateImagenRequest $request, int $id): JsonResponse
    {
        try {
            $imagen = $this->imagenService->updateImagen($id, $request->validated());
            return ApiResponse::success($imagen, 'Imagen updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Imagen not found.');
        } catch (\Exception $e) {
            Log::error('Error updating imagen: ' . $e->getMessage());
            return ApiResponse::error('Failed to update imagen.');
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
            $this->imagenService->deleteImagen($id);
            return ApiResponse::noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Imagen not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting imagen: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete imagen.');
        }
    }

    /**
     * Set an image as the main image.
     *
     * @param  \App\Http\Requests\Imagen\SetPrincipalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAsPrincipal(SetPrincipalRequest $request, int $id): JsonResponse
    {
        try {
            $this->imagenService->setAsPrincipal($id);
            return ApiResponse::success(null, 'Imagen establecida como principal exitosamente.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Imagen not found.');
        } catch (\Exception $e) {
            Log::error('Error setting image as principal: ' . $e->getMessage());
            return ApiResponse::error('Failed to set image as principal.');
        }
    }
}
