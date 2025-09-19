<?php

namespace App\Services;

use App\Models\Categoria;
use App\Repositories\Interfaces\CategoriaRepositoryInterface;
use Illuminate\Support\Collection;

class CategoriaService extends BaseService
{
    public function __construct(CategoriaRepositoryInterface $repository)
    {
        parent::__construct($repository);
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
