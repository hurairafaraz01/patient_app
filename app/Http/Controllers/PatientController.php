<?php

namespace App\Http\Controllers;

use App\Filters\PatientFilter;
use App\Helpers\ApiResponse;
use App\Http\Requests\PatientFilterRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Services\PatientAddressService;

class PatientController extends Controller
{
    public function __construct(
        protected PatientAddressService $addressService
    ) {}

    public function index(PatientFilterRequest $request, PatientFilter $filter)
    {
        try {
            $patients = $filter->apply(Patient::with(['createdBy', 'updatedBy']), $request->validated())
                ->latest()
                ->paginate($request->input('per_page', 20));
            return ApiResponse::paginated($patients, "Patients retrieved successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve patients.", $e->getMessage());
        }
    }

    public function store(StorePatientRequest $request)
    {
        try {
            $data = $this->addressService->syncDeliveryAddress($request->validated());

            if ($userId = auth()->id()) {
                $data['created_by'] = $userId;
                $data['updated_by'] = $userId;
            }

            $patient = Patient::create($data);
            return ApiResponse::success($patient, "Patient created successfully.", 201);
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to create patient.", $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $patient = Patient::with('dmeCases')->findOrFail($id);
            return ApiResponse::success($patient, "Patient retrieved successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve patient.", $e->getMessage());
        }
    }

    public function update(UpdatePatientRequest $request, string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $data = $this->addressService->syncDeliveryAddress($request->validated());

            if ($userId = auth()->id()) {
                $data['updated_by'] = $userId;
            }

            $patient->update($data);
            return ApiResponse::success($patient->fresh(), "Patient updated successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to update patient.", $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return ApiResponse::success(null, "Patient deleted successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to delete patient.", $e->getMessage());
        }
    }
}