<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

/**
 * @property int $id
 * @property string $nombre
 * @property bool $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Categoria extends BaseModel
{
    protected $table = 'categorias';
    
    protected $fillable = [
        'nombre'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->validate();
        });

        static::updating(function ($model) {
            $model->validate();
        });
    }

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'status' => 'boolean',
        ];
    }


    /**
     * Validate the model attributes.
     *
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): bool
    {
        Validator::make(
            $this->attributesToArray(),
            static::rules()
        )->validate();

        return true;
    }

    /**
     * Get all atractivos for the categoria.
     */
    public function atractivos(): HasMany
    {
        return $this->hasMany(Atractivo::class);
    }

    /**
     * Scope a query to only include active categorias.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

}