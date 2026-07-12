<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CaseManagerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PatientCaseController;

Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('cases', PatientCaseController::class);
    Route::get('patients/{patient}/cases', [PatientCaseController::class, 'patientCases']);
    Route::get('case-types', [CaseTypeController::class, 'getDmeCaseTypes']);
    Route::get('case-managers', [CaseManagerController::class, 'getDmeCaseManagers']);
    Route::get('providers', [ProviderController::class, 'getProviders']);
});
