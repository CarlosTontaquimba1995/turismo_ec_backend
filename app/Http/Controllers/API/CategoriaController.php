<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\CategoriaService;
use Illuminate\Http\JsonResponse;

class CategoriaController extends BaseController
{
    protected $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    public function index(): JsonResponse
    {
        $categorias = $this->categoriaService->getActiveCategorias();
        return $this->sendResponse($categorias, 'Categorías retrieved successfully.');
    }

    public function show(int $id): JsonResponse
    {
        $categoria = $this->categoriaService->getCategoriaWithAtractivos($id);
        
        if (is_null($categoria)) {
            return $this->sendError('Categoría not found.');
        }

        return $this->sendResponse($categoria, 'Categoría retrieved successfully.');
    }
}
