<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends BaseModel
{
    protected $table = 'provincias';
    protected $fillable = ['nombre', 'status'];

    public function atractivos(): HasMany
    {
        return $this->hasMany(Atractivo::class);
    }
}
