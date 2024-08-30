<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            [
                'doctor_id' => ['required'],
                'patient_name' => ['required', 'string'],
                'patient_phone' => ['required', 'string'],
                'patient_email' => ['required', 'string'],
                'date' => ['required', 'string'],
                'time' => ['required', 'string'],
                'status' => ['required', 'string'],
            ]
        ];
    }
}
