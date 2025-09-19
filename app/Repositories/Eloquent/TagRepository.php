<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TagRepository implements TagRepositoryInterface
{
    protected $model;

    public function __construct(Tag $model)
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

    public function update(int $modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);
        if (!$model) {
            return null;
        }
        $model->update($payload);
        return $model->fresh();
    }

    public function delete(int $modelId): bool
    {
        $model = $this->findById($modelId);
        return $model ? $model->delete() : false;
    }

    public function attachToAtractivo(int $atractivoId, int $tagId): void
    {
        $tag = $this->model->findOrFail($tagId);
        $tag->atractivos()->syncWithoutDetaching([$atractivoId]);
    }

    public function detachFromAtractivo(int $atractivoId, int $tagId): void
    {
        $tag = $this->model->findOrFail($tagId);
        $tag->atractivos()->detach($atractivoId);
    }

    public function getAtractivoTags(int $atractivoId): Collection
    {
        return $this->model->whereHas('atractivos', function($query) use ($atractivoId) {
            $query->where('atractivos.id', $atractivoId);
        })->get();
    }
}
