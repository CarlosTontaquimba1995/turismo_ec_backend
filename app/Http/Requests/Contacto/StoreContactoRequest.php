<?php

namespace App\Http\Requests\Contacto;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactoRequest extends FormRequest
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
            'atractivo_id' => 'required|exists:atractivos,id',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'web' => 'nullable|url|max:200',
        ];
    }
}
