<?php

namespace App\Http\Requests\Categoria;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
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
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'status' => 'sometimes|boolean|nullable',
            'descripcion' => 'nullable|string|max:255',
            'icono' => 'nullable|string|max:50',
            'color' => 'nullable|string|size:7|regex:/^#[0-9a-fA-F]{6}$/'
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
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nombre.unique' => 'Ya existe una categoría con este nombre.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',
            'descripcion.max' => 'La descripción no debe exceder los 255 caracteres.',
            'icono.max' => 'El ícono no debe exceder los 50 caracteres.',
            'color.size' => 'El color debe tener exactamente 7 caracteres (incluyendo el #).',
            'color.regex' => 'El formato del color debe ser # seguido de 6 caracteres hexadecimales (ej: #AABBCC).',
        ];
    }
}
