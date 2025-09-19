<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenAtractivo extends BaseModel
{
    protected $table = 'imagenes_atractivos';
    protected $fillable = [
        'atractivo_id',
        'url',
        'descripcion',
        'es_principal',
        'status'
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'status' => 'boolean',
    ];

    public function atractivo(): BelongsTo
    {
        return $this->belongsTo(Atractivo::class);
    }
}
