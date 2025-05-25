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
            'table_number' => [
                'required',
                'integer',
                'max:255',
                Rule::unique('tables', 'table_number')->ignore($tableId),
            ], 'capacity' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'table_number.unique' => 'Já existe uma mesa com esse nome ou número',
            'table_number.required' => 'Nome ou número da mesa obrigatório',
            'capacity.required' => 'Capacidade da mesa obrigatória'
        ];
    }
}
