<?php

namespace App\Services;

use App\Models\Atractivo;
use App\Repositories\Interfaces\AtractivoRepositoryInterface;
use Illuminate\Support\Collection;

class AtractivoService extends BaseService
{
    public function __construct(AtractivoRepositoryInterface $repository)
    {
        parent::__construct($repository);
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
