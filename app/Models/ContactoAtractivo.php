<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactoAtractivo extends BaseModel
{
    protected $table = 'contactos_atractivos';
    protected $fillable = [
        'atractivo_id',
        'telefono',
        'email',
        'web',
        'status'
    ];

    public function atractivo(): BelongsTo
    {
        return $this->belongsTo(Atractivo::class);
    }
}
