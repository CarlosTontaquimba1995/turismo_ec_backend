<?php

namespace App\Repositories\Eloquent;

use App\Models\ContactoAtractivo;
use App\Repositories\Interfaces\ContactoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactoRepository implements ContactoRepositoryInterface
{
    protected $model;

    public function __construct(ContactoAtractivo $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with('atractivo')->get();
    }

    public function find(int $id): ?ContactoAtractivo
    {
        return $this->model->with('atractivo')->findOrFail($id);
    }

    public function create(array $data): ContactoAtractivo
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?ContactoAtractivo
    {
        $contacto = $this->model->findOrFail($id);
        $contacto->update($data);
        return $contacto;
    }

    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function findByAtractivo(int $atractivoId): Collection
    {
        return $this->model->where('atractivo_id', $atractivoId)->get();
    }
}
