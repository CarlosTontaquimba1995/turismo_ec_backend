<?php

namespace App\Http\Requests\Imagen;

use Illuminate\Foundation\Http\FormRequest;

class StoreImagenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'atractivo_id' => 'required|exists:atractivos,id',
            'url' => 'required|url',
            'descripcion' => 'nullable|string',
            'es_principal' => 'sometimes|boolean',
        ];
    }
}
