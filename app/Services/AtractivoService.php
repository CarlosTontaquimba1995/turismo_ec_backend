<?php

namespace App\Services;

use App\Models\Atractivo;
use App\Repositories\Interfaces\AtractivoRepositoryInterface;
use Illuminate\Support\Collection;

class AtractivoService
{
    protected $repository;

    public function __construct(AtractivoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Atractivo
    {
        return $this->repository->findById($modelId, $columns, $relations);
    }

    public function create(array $payload): Atractivo
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

    public function getActiveAtractivos(): Collection
    {
        return $this->repository->getActiveAtractivos();
    }

    public function getAtractivoWithRelations(int $atractivoId): ?Atractivo
    {
        return $this->repository->getAtractivoWithRelations($atractivoId);
    }

    public function getAtractivosByProvincia(int $provinciaId): Collection
    {
        return $this->repository->getAtractivosByProvincia($provinciaId);
    }

    public function getAtractivosByCategoria(int $categoriaId): Collection
    {
        return $this->repository->getAtractivosByCategoria($categoriaId);
    }

    public function searchAtractivos(string $query): Collection
    {
        return $this->repository->searchAtractivos($query);
    }
}
