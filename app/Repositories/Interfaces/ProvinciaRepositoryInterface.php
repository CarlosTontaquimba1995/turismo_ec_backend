<?php

namespace App\Repositories\Interfaces;

use App\Models\Provincia;
use Illuminate\Support\Collection;

interface ProvinciaRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveProvincias(): Collection;
    public function getProvinciaWithAtractivos(int $provinciaId): ?Provincia;
}
