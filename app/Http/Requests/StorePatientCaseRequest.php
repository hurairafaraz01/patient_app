<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\VisitType;
use Illuminate\Validation\Rules\Enum;

class StorePatientCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'case_type_id' => ['required', 'exists:case_types,id'],
            'case_manager_id' => ['nullable', 'exists:case_managers,id'],
            'provider_id' => ['required', 'exists:providers,id'],
            'visit_type' => ['required', 'integer', new Enum(VisitType::class)],
            'doa' => ['nullable', 'date', 'before_or_equal:today'],
            'insurance_name' => ['nullable', 'string', 'max:255'],
            'claim_number' => ['nullable', 'string', 'max:100'],
            'policy_number' => ['nullable', 'string', 'max:100'],
            'wcb_number' => ['nullable', 'string', 'max:100'],
            'referring_office' => ['nullable', 'string', 'max:255'],
            'attorney_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}