<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacto\StoreContactoRequest;
use App\Http\Requests\Contacto\UpdateContactoRequest;
use App\Http\Responses\ApiResponse;
use App\Services\ContactoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Contacts",
 *     description="API Endpoints for managing contacts"
 * )
 * 
 * @OA\Schema(
 *     schema="Contacto",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Juan Pérez"),
 *     @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
 *     @OA\Property(property="telefono", type="string", example="+593 99 999 9999"),
 *     @OA\Property(property="mensaje", type="string", example="Me gustaría obtener más información sobre..."),
 *     @OA\Property(property="asunto", type="string", example="Consulta general"),
 *     @OA\Property(property="leido", type="boolean", example=false),
 *     @OA\Property(property="fecha_contacto", type="string", format="date-time"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ContactoController extends Controller
{
    protected $contactoService;

    public function __construct(ContactoService $contactoService)
    {
        $this->contactoService = $contactoService;
    }

    /**
     * @OA\Get(
     *     path="/api/contactos",
     *     summary="Get all contacts",
     *     tags={"Contacts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of contacts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contacto")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $contactos = $this->contactoService->getAllContactos();
            return ApiResponse::success($contactos, 'Contactos retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching contactos: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve contactos.');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/contactos",
     *     summary="Create a new contact",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "email", "mensaje"},
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="telefono", type="string", example="+593 99 999 9999"),
     *             @OA\Property(property="mensaje", type="string", example="Me gustaría obtener más información sobre..."),
     *             @OA\Property(property="asunto", type="string", example="Consulta general")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Contacto")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreContactoRequest $request): JsonResponse
    {
        try {
            $contacto = $this->contactoService->createContacto($request->validated());
            return ApiResponse::created($contacto, 'Contacto created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating contacto: ' . $e->getMessage());
            return ApiResponse::error('Failed to create contacto.');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/contactos/{id}",
     *     summary="Get a specific contact",
     *     tags={"Contacts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Contact ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact details",
     *         @OA\JsonContent(ref="#/components/schemas/Contacto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $contacto = $this->contactoService->getContacto($id);
            return ApiResponse::success($contacto, 'Contacto retrieved successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Contacto not found.');
        } catch (\Exception $e) {
            Log::error('Error fetching contacto: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve contacto.');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/contactos/{id}",
     *     summary="Update a contact",
     *     tags={"Contacts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Contact ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez Actualizado"),
     *             @OA\Property(property="email", type="string", format="email", example="nuevo@example.com"),
     *             @OA\Property(property="telefono", type="string", example="+593 98 888 8888"),
     *             @OA\Property(property="mensaje", type="string", example="Mensaje actualizado"),
     *             @OA\Property(property="asunto", type="string", example="Nuevo asunto"),
     *             @OA\Property(property="leido", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Contacto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateContactoRequest $request, int $id): JsonResponse
    {
        try {
            $contacto = $this->contactoService->updateContacto($id, $request->validated());
            return ApiResponse::success($contacto, 'Contacto updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Contacto not found.');
        } catch (\Exception $e) {
            Log::error('Error updating contacto: ' . $e->getMessage());
            return ApiResponse::error('Failed to update contacto.');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/contactos/{id}",
     *     summary="Delete a contact",
     *     tags={"Contacts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Contact ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->contactoService->deleteContacto($id);
            return ApiResponse::noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Contacto not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting contacto: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete contacto.');
        }
    }

    /**
     * Get contactos by atractivo ID.
     *
     * @param  int  $atractivoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byAtractivo(int $atractivoId): JsonResponse
    {
        try {
            $contactos = $this->contactoService->getContactosByAtractivo($atractivoId);
            return ApiResponse::success($contactos, 'Contactos by atractivo retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching contactos by atractivo: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve contactos by atractivo.');
        }
    }
}
