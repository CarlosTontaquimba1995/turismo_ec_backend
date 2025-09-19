<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Services\ProvinciaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvinciaController extends BaseController
{
    protected $provinciaService;

    public function __construct(ProvinciaService $provinciaService)
    {
        $this->provinciaService = $provinciaService;
    }

    public function index(): JsonResponse
    {
        $provincias = $this->provinciaService->getActiveProvincias();
        return $this->sendResponse($provincias, 'Provincias retrieved successfully.');
    }

    public function show(int $id): JsonResponse
    {
        $provincia = $this->provinciaService->getProvinciaWithAtractivos($id);
        
        if (is_null($provincia)) {
            return $this->sendError('Provincia not found.');
        }

        return $this->sendResponse($provincia, 'Provincia retrieved successfully.');
    }
}
