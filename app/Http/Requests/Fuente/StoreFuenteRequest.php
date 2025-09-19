<?php

namespace App\Http\Requests\Fuente;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuenteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'url' => 'nullable|url',
            'fecha_obtenido' => 'required|date',
        ];
    }
}
