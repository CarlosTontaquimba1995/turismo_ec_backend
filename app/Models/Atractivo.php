<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Atractivo extends BaseModel
{
    protected $table = 'atractivos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'provincia_id',
        'categoria_id',
        'lat',
        'lon',
        'direccion',
        'nivel_importancia',
        'estado',
        'fuente_id',
        'status'
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
        'status' => 'boolean',
    ];

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function fuente(): BelongsTo
    {
        return $this->belongsTo(Fuente::class);
    }

    public function contacto(): HasOne
    {
        return $this->hasOne(ContactoAtractivo::class, 'atractivo_id');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenAtractivo::class, 'atractivo_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'atractivo_tags', 'atractivo_id', 'tag_id');
    }
}
