<?php

namespace App\Repositories\Interfaces;

use App\Models\Provincia;
use Illuminate\Support\Collection;

interface ProvinciaRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Provincia;
    public function create(array $payload): Provincia;
    public function update(int $modelId, array $payload): bool;
    public function deleteById(int $modelId): bool;
    
    public function getActiveProvincias(): Collection;
    public function getProvinciaWithAtractivos(int $provinciaId): ?Provincia;
}
