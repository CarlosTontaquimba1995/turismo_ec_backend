<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Fuente extends BaseModel
{
    protected $table = 'fuentes';
    protected $fillable = ['nombre', 'url', 'fecha_obtenido'];
    protected $dates = ['fecha_obtenido'];

    public function atractivos(): HasMany
    {
        return $this->hasMany(Atractivo::class);
    }
}
