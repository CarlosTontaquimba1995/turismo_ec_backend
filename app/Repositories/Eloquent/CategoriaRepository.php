<?php

namespace App\Repositories\Eloquent;

use App\Models\Categoria;
use App\Repositories\Interfaces\CategoriaRepositoryInterface;
use Illuminate\Support\Collection;

class CategoriaRepository implements CategoriaRepositoryInterface
{
    protected Categoria $model;

    public function __construct(Categoria $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Categoria
    {
        return $this->model->find($id);
    }

    public function create(array $data): Categoria
    {
        $categoria = new Categoria($data);
        $categoria->save();
        return $categoria;
    }

    public function update(int $id, array $data): ?Categoria
    {
        $categoria = $this->find($id);
        
        if (!$categoria) {
            return null;
        }

        $categoria->update($data);
        return $categoria->fresh();
    }

    public function delete(int $id): bool
    {
        $categoria = $this->find($id);
        
        if (!$categoria) {
            return false;
        }

        return $categoria->delete();
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
