<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

Route::get('/modelos', function() {
    return view('app.modelos');
})->name('modelos')->middleware('auth');
