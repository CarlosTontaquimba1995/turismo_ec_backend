<?php

namespace App\Http\Requests\Provincia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProvinciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:100|unique:provincias,nombre,' . $this->route('provincia'),
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
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nombre.unique' => 'Ya existe una provincia con este nombre.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
