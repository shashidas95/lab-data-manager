<?php


use App\Http\Controllers\LabController;
use App\Http\Controllers\LabSampleController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BdsFoodStandardController;
use App\Http\Controllers\FoodSampleController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('offices', OfficeController::class);
Route::apiResource('manufacturers', ManufacturerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('labs', LabController::class);
Route::apiResource('units', UnitController::class);
Route::apiResource('parameters', ParameterController::class);
Route::apiResource('tests', TestController::class);
Route::apiResource('samples', LabSampleController::class);

// BSTI Chemical & Food Wing API endpoints
Route::apiResource('bds-food-standards', BdsFoodStandardController::class);
Route::apiResource('food-samples', FoodSampleController::class);
Route::put('food-samples/{id}/status', [FoodSampleController::class, 'updateStatus']);
Route::post('food-samples/{id}/results', [FoodSampleController::class, 'recordResults']);

// routes/api.php
Route::get('public/verify/{id}', [App\Http\Controllers\LabSampleController::class, 'showPublic']);
Route::get('public/verify/food/{code}', [FoodSampleController::class, 'verifyPublic']);

// HRM & Leave Management Endpoints
Route::post('hrm/profiles', [App\Http\Controllers\EmployeeController::class, 'storeProfile']);
Route::get('hrm/profiles', [App\Http\Controllers\EmployeeController::class, 'index']);
Route::get('hrm/leaves', [App\Http\Controllers\EmployeeController::class, 'listLeaves']);
Route::post('hrm/leaves', [App\Http\Controllers\EmployeeController::class, 'requestLeave']);
Route::put('hrm/leaves/{id}/status', [App\Http\Controllers\EmployeeController::class, 'updateLeaveStatus']);

// Payroll, Loans & GPF Endpoints
Route::get('payroll/records', [App\Http\Controllers\PayrollController::class, 'index']);
Route::post('payroll/records/process', [App\Http\Controllers\PayrollController::class, 'processSalary']);
Route::post('payroll/loans', [App\Http\Controllers\PayrollController::class, 'issueLoan']);
Route::post('payroll/gpf', [App\Http\Controllers\PayrollController::class, 'updateGpf']);

// Certification Applications & Auditing Endpoints
Route::get('certifications/applications', [App\Http\Controllers\CertificationController::class, 'listApplications']);
Route::post('certifications/applications', [App\Http\Controllers\CertificationController::class, 'submitApplication']);
Route::put('certifications/applications/{id}/status', [App\Http\Controllers\CertificationController::class, 'updateApplicationStatus']);
Route::post('certifications/audits', [App\Http\Controllers\CertificationController::class, 'recordAudit']);
