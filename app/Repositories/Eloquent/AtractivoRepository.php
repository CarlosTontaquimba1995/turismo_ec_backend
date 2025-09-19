<?php

namespace App\Repositories\Eloquent;

use App\Models\Atractivo;
use App\Repositories\Interfaces\AtractivoRepositoryInterface;
use Illuminate\Support\Collection;

class AtractivoRepository implements AtractivoRepositoryInterface
{
    protected $model;

    public function __construct(Atractivo $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Atractivo
    {
        return $this->model->with($relations)->select($columns)->find($modelId);
    }

    public function create(array $payload): Atractivo
    {
        return $this->model->create($payload);
    }

    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);
        
        if (!$model) {
            return false;
        }
        
        return $model->update($payload);
    }

    public function deleteById(int $modelId): bool
    {
        $model = $this->findById($modelId);
        
        if (!$model) {
            return false;
        }
        
        return $model->delete();
    }

    public function getActiveAtractivos(): Collection
    {
        return $this->model
            ->with(['provincia', 'categoria', 'fuente', 'contacto', 'imagenes', 'tags'])
            ->where('status', true)
            ->get();
    }

    public function getAtractivoWithRelations(int $atractivoId): ?Atractivo
    {
        return $this->model
            ->with(['provincia', 'categoria', 'fuente', 'contacto', 'imagenes', 'tags'])
            ->where('status', true)
            ->find($atractivoId);
    }

    public function getAtractivosByProvincia(int $provinciaId): Collection
    {
        return $this->model
            ->with(['provincia', 'categoria', 'imagenes'])
            ->where('provincia_id', $provinciaId)
            ->where('status', true)
            ->get();
    }

    public function getAtractivosByCategoria(int $categoriaId): Collection
    {
        return $this->model
            ->with(['provincia', 'categoria', 'imagenes'])
            ->where('categoria_id', $categoriaId)
            ->where('status', true)
            ->get();
    }

    public function searchAtractivos(string $query): Collection
    {
        return $this->model
            ->with(['provincia', 'categoria', 'imagenes'])
            ->where('nombre', 'like', "%{$query}%")
            ->orWhere('descripcion', 'like', "%{$query}%")
            ->where('status', true)
            ->get();
    }
}
