<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

/**
 * @property int $id
 * @property string $nombre
 * @property bool $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Provincia extends BaseModel
{
    protected $table = 'provincias';
    
    protected $fillable = [
        'nombre',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:provincias,nombre',
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
     * Get all atractivos for the provincia.
     */
    public function atractivos(): HasMany
    {
        return $this->hasMany(Atractivo::class);
    }

    /**
     * Scope a query to only include active provincias.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the validation rules for updating the model.
     *
     * @param  int  $id
     * @return array
     */
    public static function updateRules($id): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:provincias,nombre,' . $id,
            'status' => 'boolean',
        ];
    }
}
