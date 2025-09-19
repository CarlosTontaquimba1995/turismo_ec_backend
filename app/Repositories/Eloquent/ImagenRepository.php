<?php

namespace App\Repositories\Eloquent;

use App\Models\ImagenAtractivo;
use App\Repositories\Interfaces\ImagenRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ImagenRepository implements ImagenRepositoryInterface
{
    protected $model;

    public function __construct(ImagenAtractivo $model)
    {
        $this->model = $model;
    }

    public function getByAtractivo(int $atractivoId): Collection
    {
        return $this->model->where('atractivo_id', $atractivoId)->get();
    }

    public function find(int $id): ?ImagenAtractivo
    {
        return $this->model->find($id);
    }

    public function create(array $data): ImagenAtractivo
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?ImagenAtractivo
    {
        $imagen = $this->model->find($id);
        if ($imagen) {
            $imagen->update($data);
            return $imagen;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function count(array $conditions = []): int
    {
        $query = $this->model->query();
        
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        
        return $query->count();
    }

    public function setAsPrincipal(int $imagenId): void
    {
        $imagen = $this->model->findOrFail($imagenId);
        $this->unsetOtherPrincipals($imagen->atractivo_id, $imagen->id);
        $imagen->update(['es_principal' => true]);
    }

    public function unsetOtherPrincipals(int $atractivoId, int $excludeId = null): void
    {
        $query = $this->model->where('atractivo_id', $atractivoId)
            ->where('es_principal', true);
            
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $query->update(['es_principal' => false]);
    }

    public function findByAtractivo(int $atractivoId): Collection
    {
        return $this->model->where('atractivo_id', $atractivoId)->get();
    }
}
