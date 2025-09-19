<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $provincia_id
 * @property int $categoria_id
 * @property float $lat
 * @property float $lon
 * @property string $direccion
 * @property string $nivel_importancia
 * @property string $estado
 * @property int $fuente_id
 * @property bool $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
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
        'fuente_id'
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'provincia_id' => 'required|exists:provincias,id',
            'categoria_id' => 'required|exists:categorias,id',
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
            'direccion' => 'required|string|max:500',
            'nivel_importancia' => 'required|in:baja,media,alta',
            'estado' => 'required|string|max:50',
            'fuente_id' => 'required|exists:fuentes,id',
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
     * Get the provincia that owns the atractivo.
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Get the categoria that owns the atractivo.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Get the fuente that owns the atractivo.
     */
    public function fuente(): BelongsTo
    {
        return $this->belongsTo(Fuente::class);
    }

    /**
     * Get the contacto associated with the atractivo.
     */
    public function contacto(): HasOne
    {
        return $this->hasOne(ContactoAtractivo::class, 'atractivo_id');
    }

    /**
     * Scope a query to only include active atractivos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get all imagenes for the atractivo.
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenAtractivo::class, 'atractivo_id');
    }

    /**
     * The tags that belong to the atractivo.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'atractivo_tags', 'atractivo_id', 'tag_id');
    }
}