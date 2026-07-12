<?php

namespace App\Http\Controllers;

use App\Models\CaseType;
use App\Helpers\ApiResponse;

class CaseTypeController extends Controller
{
    public function getDmeCaseTypes()
    {
        try {
            return ApiResponse::success(CaseType::select('id', 'name')->get(), 'Case types retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve case types', $e->getMessage());
        }
    }
}
