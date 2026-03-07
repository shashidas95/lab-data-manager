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
// routes/api.php
Route::get('public/verify/{id}', [App\Http\Controllers\LabSampleController::class, 'showPublic']);
