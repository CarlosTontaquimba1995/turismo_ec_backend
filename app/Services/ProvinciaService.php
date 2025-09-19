<?php

namespace App\Services;

use App\Models\Provincia;
use App\Repositories\Interfaces\ProvinciaRepositoryInterface;
use Illuminate\Support\Collection;

class ProvinciaService
{
    protected $repository;

    public function __construct(ProvinciaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    public function find(int $id, array $columns = ['*'], array $relations = []): ?Provincia
    {
        return $this->repository->findById($id, $columns, $relations);
    }

    public function createProvincia(array $data): Provincia
    {
        return $this->repository->create($data);
    }

    public function updateProvincia(int $id, array $data): ?Provincia
    {
        $updated = $this->repository->update($id, $data);
        
        if (!$updated) {
            return null;
        }
        
        return $this->find($id);
    }

    public function deleteProvincia(int $id): bool
    {
        return $this->repository->deleteById($id);
    }

    public function getActiveProvincias(): Collection
    {
        return $this->repository->getActiveProvincias();
    }

    public function getProvinciaWithAtractivos(int $provinciaId): ?Provincia
    {
        return $this->repository->getProvinciaWithAtractivos($provinciaId);
    }
}
