<?php

namespace App\Repositories\Interfaces;

use App\Models\Categoria;
use Illuminate\Support\Collection;

interface CategoriaRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveCategorias(): Collection;
    public function getCategoriaWithAtractivos(int $categoriaId): ?Categoria;
}
