<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'numbers' => 'required|array|min:6|max:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Necessário fornecer o Nome',
            'name.max' => 'Necessário que o Nome possua no máximo 200 caracteres',
            'numbers.required' => 'Necessário fornecer os Números',
            'numbers.array' => 'Necessário fornecer os Números no formato Array',
            'numbers.min' => 'Necessário que sejam fornecidos 6 números',
            'numbers.max' => 'Necessário que sejam fornecidos 6 números',
        ];
    }
}
