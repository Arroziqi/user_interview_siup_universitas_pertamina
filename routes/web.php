<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyPageController;
use App\Http\Controllers\ProgramPageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faculties', function(){
    return view('faculties.index');
})->name('faculties.index');
Route::get('/programs', function (){
    return view('programs.index');
})->name('programs.index');