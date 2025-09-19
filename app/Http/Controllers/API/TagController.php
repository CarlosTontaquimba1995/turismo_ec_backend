<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\TagAttachRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Responses\ApiResponse;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tags = $this->tagService->getAllTags();
            return ApiResponse::success($tags, 'Lista de tags obtenida exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al obtener los tags: ' . $e->getMessage());
            return ApiResponse::error('Error al obtener los tags');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Tag\StoreTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        try {
            $tag = $this->tagService->createTag($request->validated());
            return ApiResponse::success($tag, 'Tag creado exitosamente', 201);
        } catch (\Exception $e) {
            Log::error('Error al crear el tag: ' . $e->getMessage());
            return ApiResponse::error('Error al crear el tag');
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
            $tag = $this->tagService->getTag($id);
            return ApiResponse::success($tag, 'Tag obtenido exitosamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Tag no encontrado');
        } catch (\Exception $e) {
            Log::error('Error al obtener el tag: ' . $e->getMessage());
            return ApiResponse::error('Error al obtener el tag');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Tag\UpdateTagRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTagRequest $request, int $id): JsonResponse
    {
        try {
            $tag = $this->tagService->updateTag($id, $request->validated());
            return ApiResponse::success($tag, 'Tag actualizado exitosamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Tag no encontrado');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el tag: ' . $e->getMessage());
            return ApiResponse::error('Error al actualizar el tag');
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
            $this->tagService->deleteTag($id);
            return ApiResponse::noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::notFound('Tag no encontrado');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el tag: ' . $e->getMessage());
            return ApiResponse::error('Error al eliminar el tag');
        }
    }

    /**
     * Attach tags to an atractivo.
     *
     * @param  \App\Http\Requests\Tag\TagAttachRequest  $request
     * @param  int  $atractivoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachToAtractivo(TagAttachRequest $request, int $atractivoId): JsonResponse
    {
        try {
            $this->tagService->attachToAtractivo($atractivoId, $request->input('tag_id'));
            return ApiResponse::success(null, 'Tag asociado al atractivo exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al asociar el tag al atractivo: ' . $e->getMessage());
            return ApiResponse::error('Error al asociar el tag al atractivo');
        }
    }

    /**
     * Detach a tag from an atractivo.
     *
     * @param  int  $atractivoId
     * @param  int  $tagId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachFromAtractivo(int $atractivoId, int $tagId): JsonResponse
    {
        try {
            $this->tagService->detachFromAtractivo($atractivoId, $tagId);
            return ApiResponse::success(null, 'Tag desasociado del atractivo exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al desasociar el tag del atractivo: ' . $e->getMessage());
            return ApiResponse::error('Error al desasociar el tag del atractivo');
        }
    }

    /**
     * Get tags by atractivo ID.
     *
     * @param  int  $atractivoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByAtractivo(int $atractivoId): JsonResponse
    {
        try {
            $tags = $this->tagService->getAtractivoTags($atractivoId);
            return ApiResponse::success($tags, 'Tags del atractivo obtenidos exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al obtener los tags del atractivo: ' . $e->getMessage());
            return ApiResponse::error('Error al obtener los tags del atractivo');
        }
    }
}