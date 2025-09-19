<?php

namespace App\Services;

use App\Models\ContactoAtractivo;
use App\Repositories\Interfaces\ContactoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactoService
{
    protected $contactoRepository;

    public function __construct(ContactoRepositoryInterface $contactoRepository)
    {
        $this->contactoRepository = $contactoRepository;
    }

    public function getAllContactos(): Collection
    {
        return $this->contactoRepository->all();
    }

    public function getContacto(int $id): ?ContactoAtractivo
    {
        return $this->contactoRepository->find($id);
    }

    public function createContacto(array $data): ContactoAtractivo
    {
        return $this->contactoRepository->create($data);
    }

    public function updateContacto(int $id, array $data): ?ContactoAtractivo
    {
        return $this->contactoRepository->update($id, $data);
    }

    public function deleteContacto(int $id): bool
    {
        return $this->contactoRepository->delete($id);
    }

    public function getContactosByAtractivo(int $atractivoId): Collection
    {
        return $this->contactoRepository->findByAtractivo($atractivoId);
    }
}
