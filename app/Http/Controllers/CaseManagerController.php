<?php

namespace App\Http\Controllers;

use App\Models\CaseManager;
use App\Helpers\ApiResponse;

class CaseManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCaseManagers()
    {
        try {
            return ApiResponse::success(CaseManager::select('id', 'name')->get(), 'case managers retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve case managers', $e->getMessage());
        }
    }
}
