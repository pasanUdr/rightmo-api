<?php

use App\Http\Controllers\Api\csvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/importStudents',[csvController::class,'importStudents'])->name('import');