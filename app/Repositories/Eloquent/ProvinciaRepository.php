<?php

namespace App\Repositories\Eloquent;

use App\Models\Provincia;
use App\Repositories\Interfaces\ProvinciaRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProvinciaRepository implements ProvinciaRepositoryInterface
{
    protected $model;

    public function __construct(Provincia $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Provincia
    {
        return $this->model->with($relations)->select($columns)->find($modelId);
    }

    public function create(array $payload): Provincia
    {
        $model = $this->model->create($payload);
        return $model->fresh();
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

    public function getActiveProvincias(): Collection
    {
        return $this->model->where('status', true)->get();
    }

    public function getProvinciaWithAtractivos(int $provinciaId): ?Provincia
    {
        return $this->model
            ->with(['atractivos' => function($query) {
                $query->where('status', true);
            }])
            ->find($provinciaId);
    }
}
