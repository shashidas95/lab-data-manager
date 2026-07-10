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
