<?php

namespace App\Services;

use App\Models\Categoria;
use App\Repositories\Interfaces\CategoriaRepositoryInterface;
use Illuminate\Support\Collection;

class CategoriaService
{
    protected CategoriaRepositoryInterface $repository;

    public function __construct(CategoriaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(int $id): ?Categoria
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Categoria
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Categoria
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getActiveCategorias(): Collection
    {
        return $this->repository->getActiveCategorias();
    }

    public function getCategoriaWithAtractivos(int $categoriaId): ?Categoria
    {
        return $this->repository->getCategoriaWithAtractivos($categoriaId);
    }
}
