<?php

namespace App\Services;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->repository->findById($modelId, $columns, $relations, $appends);
    }

    public function create(array $payload): ?Model
    {
        return $this->repository->create($payload);
    }

    public function update(int $modelId, array $payload): bool
    {
        return $this->repository->update($modelId, $payload);
    }

    public function deleteById(int $modelId): bool
    {
        return $this->repository->deleteById($modelId);
    }

    public function restoreById(int $modelId): bool
    {
        return $this->repository->restoreById($modelId);
    }

    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->repository->permanentlyDeleteById($modelId);
    }
}
