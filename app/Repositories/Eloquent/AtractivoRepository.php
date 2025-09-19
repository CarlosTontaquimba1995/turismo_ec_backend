<?php

namespace App\Repositories\Eloquent;

use App\Models\Atractivo;
use App\Repositories\Interfaces\AtractivoRepositoryInterface;
use Illuminate\Support\Collection;

class AtractivoRepository extends BaseRepository implements AtractivoRepositoryInterface
{
    public function __construct(Atractivo $model)
    {
        parent::__construct($model);
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
