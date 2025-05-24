<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableStoreRequest extends FormRequest
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

        $tableId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tables', 'name')->ignore($tableId),
            ], 'capacity' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Já existe uma mesa com esse nome ou número',
            'name.required' => 'Nome ou número da mesa obrigatório',
            'capacity.required' => 'Capacidade da mesa obrigatória'
        ];
    }
}
