<?php

namespace App\Repositories\Eloquent;

use App\Models\Categoria;
use App\Repositories\Interfaces\CategoriaRepositoryInterface;
use Illuminate\Support\Collection;

class CategoriaRepository extends BaseRepository implements CategoriaRepositoryInterface
{
    public function __construct(Categoria $model)
    {
        parent::__construct($model);
    }

    public function getActiveCategorias(): Collection
    {
        return $this->model->where('status', true)->get();
    }

    public function getCategoriaWithAtractivos(int $categoriaId): ?Categoria
    {
        return $this->model
            ->with(['atractivos' => function($query) {
                $query->where('status', true);
            }])
            ->find($categoriaId);
    }
}
