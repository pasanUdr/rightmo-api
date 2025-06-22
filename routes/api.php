<?php

use App\Http\Controllers\Api\CsvController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/import-data',[CsvController::class,'importData']);

Route::get('/show-all-marks',[StudentController::class,'showAllMarks']);

Route::get('/subject-analysis',[SubjectController::class,'subjectAnalysis']);
Route::get('/chart-data',[SubjectController::class,'chartData']);

