<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends BaseModel
{
    protected $table = 'categorias';
    protected $fillable = ['nombre', 'status'];

    public function atractivos(): HasMany
    {
        return $this->hasMany(Atractivo::class);
    }
}
