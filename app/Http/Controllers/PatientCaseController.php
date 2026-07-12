<?php

namespace App\Http\Controllers;

use App\Filters\PatientCaseFilter;
use App\Helpers\ApiResponse;
use App\Http\Requests\PatientCaseFilterRequest;
use App\Http\Requests\StorePatientCaseRequest;
use App\Http\Requests\UpdatePatientCaseRequest;
use App\Models\Patient;
use App\Models\PatientCase;
use Illuminate\Http\Request;

class PatientCaseController extends Controller
{
    /**
     * GET /api/cases
     */
    public function index(PatientCaseFilterRequest $request, PatientCaseFilter $filter)
    {
        try {
            $cases = $filter->apply(
                PatientCase::with(['patient', 'caseType', 'caseManager', 'provider', 'createdBy', 'updatedBy']),
                $request->validated()
            )->latest()->paginate($request->input('per_page', 20));

            return ApiResponse::paginated($cases, "Cases retrieved successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve cases.", $e->getMessage());
        }
    }

    /**
     * GET /api/patients/{patient}/cases
     */
    public function patientCases(Request $request, Patient $patient)
    {
        try {
            $cases = $patient->patientCases()
                ->with(['caseType', 'caseManager', 'provider'])
                ->latest()
                ->paginate($request->input('per_page', 20));

            return ApiResponse::paginated($cases, "Patient cases retrieved successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve patient cases.", $e->getMessage());
        }
    }

    /**
     * POST /api/cases
     */
    public function store(StorePatientCaseRequest $request)
    {
        try {
            $data = $request->validated();
            if ($userId = auth()->id()) {
                $data['created_by'] = $userId;
                $data['updated_by'] = $userId;
            }
            $case = PatientCase::create($data);

            return ApiResponse::success(
                $case->load(['patient', 'caseType', 'caseManager', 'provider']),
                "Case created successfully.",
                201
            );
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to create case.", $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $case = PatientCase::with(['patient', 'caseType', 'caseManager', 'provider'])->findOrFail($id);
            return ApiResponse::success($case, "Case retrieved successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve case.", $e->getMessage());
        }
    }

    public function update(UpdatePatientCaseRequest $request, string $id)
    {
        try {
            $case = PatientCase::findOrFail($id);
            $data = $request->validated();
            if ($userId = auth()->id()) {
                $data['updated_by'] = $userId;
            }
            $case->update($data);

            return ApiResponse::success(
                $case->fresh(['patient', 'caseType', 'caseManager', 'provider']),
                "Case updated successfully."
            );
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to update case.", $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $case = PatientCase::findOrFail($id);
            $case->delete();
            return ApiResponse::success(null, "Case deleted successfully.");
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to delete case.", $e->getMessage());
        }
    }
}