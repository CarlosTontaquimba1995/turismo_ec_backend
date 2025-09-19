<?php

namespace App\Repositories\Eloquent;

use App\Models\Fuente;
use App\Repositories\Interfaces\FuenteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FuenteRepository implements FuenteRepositoryInterface
{
    protected $model;

    public function __construct(Fuente $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->model->with($relations)->select($columns)->find($modelId);
    }

    public function create(array $payload): Model
    {
        return $this->model->create($payload);
    }

    public function update(int $modelId, array $payload): ?Fuente
    {
        $fuente = $this->model->findOrFail($modelId);
        $fuente->update($payload);
        return $fuente;
    }

    public function deleteById(int $modelId): bool
    {
        $model = $this->findById($modelId);
        return $model ? $model->delete() : false;
    }
}
