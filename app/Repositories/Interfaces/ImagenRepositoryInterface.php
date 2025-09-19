<?php

namespace App\Repositories\Interfaces;

use App\Models\ImagenAtractivo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ImagenRepositoryInterface
{
    public function getByAtractivo(int $atractivoId): Collection;
    public function find(int $id): ?ImagenAtractivo;
    public function create(array $data): ImagenAtractivo;
    public function update(int $id, array $data): ?ImagenAtractivo;
    public function delete(int $id): bool;
    public function count(array $conditions = []): int;
    public function setAsPrincipal(int $imagenId): void;
    public function unsetOtherPrincipals(int $atractivoId, int $excludeId = null): void;
    public function findByAtractivo(int $atractivoId): Collection;
}
