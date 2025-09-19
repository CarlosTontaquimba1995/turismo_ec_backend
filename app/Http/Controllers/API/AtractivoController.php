<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\AtractivoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtractivoController extends BaseController
{
    protected $atractivoService;

    public function __construct(AtractivoService $atractivoService)
    {
        $this->atractivoService = $atractivoService;
    }

    public function index(): JsonResponse
    {
        $atractivos = $this->atractivoService->getActiveAtractivos();
        return $this->sendResponse($atractivos, 'Atractivos retrieved successfully.');
    }

    public function show(int $id): JsonResponse
    {
        $atractivo = $this->atractivoService->getAtractivoWithRelations($id);
        
        if (is_null($atractivo)) {
            return $this->sendError('Atractivo not found.');
        }

        return $this->sendResponse($atractivo, 'Atractivo retrieved successfully.');
    }

    public function byProvincia(int $provinciaId): JsonResponse
    {
        $atractivos = $this->atractivoService->getAtractivosByProvincia($provinciaId);
        return $this->sendResponse($atractivos, 'Atractivos by provincia retrieved successfully.');
    }

    public function byCategoria(int $categoriaId): JsonResponse
    {
        $atractivos = $this->atractivoService->getAtractivosByCategoria($categoriaId);
        return $this->sendResponse($atractivos, 'Atractivos by categoría retrieved successfully.');
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return $this->sendError('Search query is required.');
        }

        $atractivos = $this->atractivoService->searchAtractivos($query);
        return $this->sendResponse($atractivos, 'Search results retrieved successfully.');
    }
}
