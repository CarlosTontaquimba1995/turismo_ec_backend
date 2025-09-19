<?php

namespace App\Services;

use App\Models\ImagenAtractivo;
use App\Repositories\Interfaces\ImagenRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ImagenService
{
    protected $imagenRepository;

    public function __construct(ImagenRepositoryInterface $imagenRepository)
    {
        $this->imagenRepository = $imagenRepository;
    }

    public function getByAtractivo(int $atractivoId): Collection
    {
        return $this->imagenRepository->getByAtractivo($atractivoId);
    }

    public function getImagen(int $id): ?ImagenAtractivo
    {
        return $this->imagenRepository->find($id);
    }

    public function createImagen(array $data): ImagenAtractivo
    {
        $imagen = $this->imagenRepository->create($data);
        
        // If this is the first image, set it as principal
        if ($this->imagenRepository->count(['atractivo_id' => $data['atractivo_id']]) === 1) {
            $this->setAsPrincipal($imagen->id);
        } elseif (isset($data['es_principal']) && $data['es_principal']) {
            $this->setAsPrincipal($imagen->id);
        }
        
        return $imagen;
    }

    public function updateImagen(int $id, array $data): ?ImagenAtractivo
    {
        $imagen = $this->imagenRepository->update($id, $data);
        
        if (isset($data['es_principal']) && $data['es_principal']) {
            $this->setAsPrincipal($id);
        }
        
        return $imagen;
    }

    public function deleteImagen(int $id): bool
    {
        $imagen = $this->imagenRepository->find($id);
        $wasPrincipal = $imagen->es_principal;
        $atractivoId = $imagen->atractivo_id;
        
        $result = $this->imagenRepository->delete($id);
        
        // If we deleted the principal image, set another one as principal
        if ($wasPrincipal) {
            $firstImage = $this->imagenRepository->findByAtractivo($atractivoId)->first();
            if ($firstImage) {
                $this->setAsPrincipal($firstImage->id);
            }
        }
        
        return $result;
    }

    public function setAsPrincipal(int $imagenId): void
    {
        $this->imagenRepository->setAsPrincipal($imagenId);
    }
}
