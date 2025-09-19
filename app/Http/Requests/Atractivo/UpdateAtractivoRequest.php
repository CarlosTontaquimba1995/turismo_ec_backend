<?php

namespace App\Http\Requests\Atractivo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAtractivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'provincia_id' => 'sometimes|exists:provincias,id',
            'categoria_id' => 'sometimes|exists:categorias,id',
            'lat' => 'sometimes|numeric|between:-90,90',
            'lon' => 'sometimes|numeric|between:-180,180',
            'direccion' => 'sometimes|string|max:500',
            'nivel_importancia' => 'sometimes|in:baja,media,alta',
            'estado' => 'sometimes|string|max:50',
            'fuente_id' => 'sometimes|exists:fuentes,id',
            'status' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre debe ser un texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'provincia_id.exists' => 'La provincia seleccionada no es válida.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'lat.numeric' => 'La latitud debe ser un número.',
            'lat.between' => 'La latitud debe estar entre -90 y 90 grados.',
            'lon.numeric' => 'La longitud debe ser un número.',
            'lon.between' => 'La longitud debe estar entre -180 y 180 grados.',
            'direccion.string' => 'La dirección debe ser un texto.',
            'direccion.max' => 'La dirección no debe exceder los 500 caracteres.',
            'nivel_importancia.in' => 'El nivel de importancia debe ser: baja, media o alta.',
            'estado.string' => 'El estado debe ser un texto.',
            'estado.max' => 'El estado no debe exceder los 50 caracteres.',
            'fuente_id.exists' => 'La fuente seleccionada no es válida.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
