<?php

namespace App\Repositories\Eloquent;

use App\Models\Provincia;
use App\Repositories\Interfaces\ProvinciaRepositoryInterface;
use Illuminate\Support\Collection;

class ProvinciaRepository extends BaseRepository implements ProvinciaRepositoryInterface
{
    public function __construct(Provincia $model)
    {
        parent::__construct($model);
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
