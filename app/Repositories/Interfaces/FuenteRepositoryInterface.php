<?php

namespace App\Repositories\Interfaces;

use App\Models\Fuente;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface FuenteRepositoryInterface
{
    /**
     * Get all fuentes
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Find a fuente by ID
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * Create a new fuente
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): Model;

    /**
     * Update an existing fuente
     *
     * @param int $modelId
     * @param array $payload
     * @return Fuente
     */
    public function update(int $modelId, array $payload): ?Fuente;

    /**
     * Delete a fuente by ID
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;
}
