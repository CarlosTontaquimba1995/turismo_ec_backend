<?php

namespace App\Http\Requests\Imagen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImagenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => 'sometimes|required|url',
            'descripcion' => 'nullable|string',
            'es_principal' => 'sometimes|boolean',
        ];
    }
}
