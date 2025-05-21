<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProgramController;

Route::apiResource('faculties', FacultyController::class)->names('api.faculties');
Route::apiResource('programs', ProgramController::class)->names('api.programs');
