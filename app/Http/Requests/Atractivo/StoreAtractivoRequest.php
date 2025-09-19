<?php

namespace App\Http\Requests\Atractivo;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtractivoRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'provincia_id' => 'required|exists:provincias,id',
            'categoria_id' => 'required|exists:categorias,id',
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
            'direccion' => 'required|string|max:500',
            'nivel_importancia' => 'required|in:baja,media,alta',
            'estado' => 'required|string|max:50',
            'fuente_id' => 'required|exists:fuentes,id',
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
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'provincia_id.required' => 'La provincia es obligatoria.',
            'provincia_id.exists' => 'La provincia seleccionada no es válida.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'lat.required' => 'La latitud es obligatoria.',
            'lat.numeric' => 'La latitud debe ser un número.',
            'lat.between' => 'La latitud debe estar entre -90 y 90 grados.',
            'lon.required' => 'La longitud es obligatoria.',
            'lon.numeric' => 'La longitud debe ser un número.',
            'lon.between' => 'La longitud debe estar entre -180 y 180 grados.',
            'direccion.required' => 'La dirección es obligatoria.',
            'nivel_importancia.required' => 'El nivel de importancia es obligatorio.',
            'nivel_importancia.in' => 'El nivel de importancia debe ser: baja, media o alta.',
            'estado.required' => 'El estado es obligatorio.',
            'fuente_id.required' => 'La fuente es obligatoria.',
            'fuente_id.exists' => 'La fuente seleccionada no es válida.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
