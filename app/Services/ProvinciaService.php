<?php

namespace App\Services;

use App\Models\Provincia;
use App\Repositories\Interfaces\ProvinciaRepositoryInterface;
use Illuminate\Support\Collection;

class ProvinciaService extends BaseService
{
    public function __construct(ProvinciaRepositoryInterface $repository)
    {
        parent::__construct($repository);
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
