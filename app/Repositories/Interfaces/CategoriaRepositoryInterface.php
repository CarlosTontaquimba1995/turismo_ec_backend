<?php

namespace App\Repositories\Interfaces;

use App\Models\Categoria;
use Illuminate\Support\Collection;

interface CategoriaRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Categoria;
    public function create(array $data): Categoria;
    public function update(int $id, array $data): ?Categoria;
    public function delete(int $id): bool;
    public function getActiveCategorias(): Collection;
    public function getCategoriaWithAtractivos(int $categoriaId): ?Categoria;
}
