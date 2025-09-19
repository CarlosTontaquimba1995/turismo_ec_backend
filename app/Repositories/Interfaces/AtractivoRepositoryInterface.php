<?php

namespace App\Repositories\Interfaces;

use App\Models\Atractivo;
use Illuminate\Support\Collection;

interface AtractivoRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Atractivo;
    public function create(array $payload): Atractivo;
    public function update(int $modelId, array $payload): bool;
    public function deleteById(int $modelId): bool;
    public function getActiveAtractivos(): Collection;
    public function getAtractivoWithRelations(int $atractivoId): ?Atractivo;
    public function getAtractivosByProvincia(int $provinciaId): Collection;
    public function getAtractivosByCategoria(int $categoriaId): Collection;
    public function searchAtractivos(string $query): Collection;
}
