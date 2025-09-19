<?php

namespace App\Repositories\Interfaces;

use App\Models\Atractivo;
use Illuminate\Support\Collection;

interface AtractivoRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveAtractivos(): Collection;
    public function getAtractivoWithRelations(int $atractivoId): ?Atractivo;
    public function getAtractivosByProvincia(int $provinciaId): Collection;
    public function getAtractivosByCategoria(int $categoriaId): Collection;
    public function searchAtractivos(string $query): Collection;
}
