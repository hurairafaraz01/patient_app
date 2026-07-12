<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientCaseFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['nullable', 'integer'],
            'case_type_id' => ['nullable', 'integer'],
            'case_manager_id' => ['nullable', 'integer'],
            'provider_id' => ['nullable', 'integer'],
            'claim_number' => ['nullable', 'string'],
            'doa' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}