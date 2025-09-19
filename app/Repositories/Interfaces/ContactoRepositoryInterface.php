<?php

namespace App\Repositories\Interfaces;

use App\Models\ContactoAtractivo;
use Illuminate\Database\Eloquent\Collection;

interface ContactoRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?ContactoAtractivo;
    public function create(array $data): ContactoAtractivo;
    public function update(int $id, array $data): ?ContactoAtractivo;
    public function delete(int $id): bool;
    public function findByAtractivo(int $atractivoId): Collection;
}
