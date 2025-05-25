<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
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
            'table_id' => ['required', 'exists:tables,id'],
            'number_of_guests' => ['required', 'integer', 'min:1'],
            'reservation_date' => ['required', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'table_id.required' => 'A mesa é obrigatória.',
            'table_id.exists' => 'A mesa informada não existe.',
            'number_of_guests.required' => 'Quantidade de pessoas para a reserva é obrigatório',
            'number_of_guests.min' => 'No mínimo uma pessoa na reserva deve ser informada',
            'reservation_date.required' => 'A data da reserva é obrigatória.',
            'reservation_date.date' => 'A data da reserva deve ser uma data válida.',
            'reservation_date.after' => 'A data da reserva deve ser no futuro.',
        ];
    }
}
