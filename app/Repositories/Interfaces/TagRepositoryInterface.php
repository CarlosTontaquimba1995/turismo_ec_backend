<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TagRepositoryInterface
{
    /**
     * Get all tags
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Find a tag by ID
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @return Model|Tag|null
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * Create a new tag
     *
     * @param array $payload
     * @return Model|Tag
     */
    public function create(array $payload): Model;

    /**
     * Update an existing tag
     *
     * @param int $modelId
     * @param array $payload
     * @return Model|Tag|null
     */
    public function update(int $modelId, array $payload): ?Model;

    /**
     * Delete a tag by ID
     *
     * @param int $modelId
     * @return bool
     */
    public function delete(int $modelId): bool;

    /**
     * Attach a tag to an atractivo
     *
     * @param int $atractivoId
     * @param int $tagId
     * @return void
     */
    public function attachToAtractivo(int $atractivoId, int $tagId): void;

    /**
     * Detach a tag from an atractivo
     *
     * @param int $atractivoId
     * @param int $tagId
     * @return void
     */
    public function detachFromAtractivo(int $atractivoId, int $tagId): void;

    /**
     * Get all tags for a specific atractivo
     *
     * @param int $atractivoId
     * @return Collection
     */
    public function getAtractivoTags(int $atractivoId): Collection;
}
