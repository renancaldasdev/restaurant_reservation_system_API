<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'Nome deve ser um texto',
            'email.required' => 'E-mail é obrigatório',
            'email.unique' => 'E-mail já cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha dever ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não são iguais'
        ];
    }
}
