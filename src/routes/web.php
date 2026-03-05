<?php

use App\Http\Controllers\LabController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('labs', LabController::class);
Route::apiResource('units', UnitController::class);
Route::apiResource('parameters', ParameterController::class);
Route::apiResource('tests', TestController::class);
