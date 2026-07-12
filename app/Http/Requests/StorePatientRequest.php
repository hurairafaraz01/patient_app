<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePatientRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', new Enum(Gender::class)],
            'ssn' => ['nullable', 'string', 'max:20', 'unique:patients,ssn'],
            'dob' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:255'],
            'suite_no' => ['nullable', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:20'],
            'work_phone_no' => ['nullable', 'string', 'max:20'],
            'phone_extension' => ['nullable', 'string', 'max:10'],
            'home_phone_no' => ['nullable', 'string', 'max:20'],
            'cell_phone_no' => ['required', 'string', 'max:20'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:patients,email'],
            'is_delivery_same_as_residential' => ['required', 'boolean'],
            'd_address'  => ['required_if:is_delivery_same_as_residential,false', 'nullable', 'string', 'max:255'],
            'd_suite'    => ['nullable', 'string', 'max:255'],
            'd_city'     => ['required_if:is_delivery_same_as_residential,false', 'nullable', 'string', 'max:255'],
            'd_state'    => ['required_if:is_delivery_same_as_residential,false', 'nullable', 'string', 'max:255'],
            'd_zip_code' => ['required_if:is_delivery_same_as_residential,false', 'nullable', 'string', 'max:20'],
            'created_by' => ['nullable', 'integer', 'exists:users,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
