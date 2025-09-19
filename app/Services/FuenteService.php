<?php

namespace App\Services;

use App\Models\Fuente;
use App\Repositories\Interfaces\FuenteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuenteService
{
    protected $fuenteRepository;

    public function __construct(FuenteRepositoryInterface $fuenteRepository)
    {
        $this->fuenteRepository = $fuenteRepository;
    }

    public function getAllFuentes(): Collection
    {
        return $this->fuenteRepository->all();
    }

    public function getFuente(int $id): ?Fuente
    {
        return $this->fuenteRepository->findById($id);
    }

    public function createFuente(array $data): Fuente
    {
        return $this->fuenteRepository->create($data);
    }

    public function updateFuente(int $id, array $data): Fuente
    {
        return $this->fuenteRepository->update($id, $data);
    }

    public function deleteFuente(int $id): bool
    {
        return $this->fuenteRepository->deleteById($id);
    }
}
