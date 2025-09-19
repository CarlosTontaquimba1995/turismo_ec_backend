<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags(): Collection
    {
        return $this->tagRepository->all();
    }

    public function getTag(int $id): ?Tag
    {
        return $this->tagRepository->findById($id);
    }

    public function createTag(array $data): Tag
    {
        return $this->tagRepository->create($data);
    }

    public function updateTag(int $id, array $data): ?Tag
    {
        return $this->tagRepository->update($id, $data);
    }

    public function deleteTag(int $id): bool
    {
        return $this->tagRepository->delete($id);
    }

    public function attachToAtractivo(int $atractivoId, int $tagId): void
    {
        $this->tagRepository->attachToAtractivo($atractivoId, $tagId);
    }

    public function detachFromAtractivo(int $atractivoId, int $tagId): void
    {
        $this->tagRepository->detachFromAtractivo($atractivoId, $tagId);
    }

    public function getAtractivoTags(int $atractivoId): Collection
    {
        return $this->tagRepository->getAtractivoTags($atractivoId);
    }
}
