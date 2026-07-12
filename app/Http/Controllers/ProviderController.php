<?php

namespace App\Http\Controllers;

use App\Models\provider;
use App\Helpers\ApiResponse;
class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProviders()
    {
        try {
            return ApiResponse::success(Provider::select('id', 'name')->get(), 'Providers retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve providers', $e->getMessage());
        }
    }
}
