<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends BaseModel
{
    protected $table = 'tags';
    protected $fillable = ['nombre'];

    public function atractivos(): BelongsToMany
    {
        return $this->belongsToMany(Atractivo::class, 'atractivo_tags', 'tag_id', 'atractivo_id');
    }
}
