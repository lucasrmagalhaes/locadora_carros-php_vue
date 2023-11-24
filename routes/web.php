<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/clientes', function() {
    return view('app.clientes');
})->name('clientes')->middleware('auth');

Route::get('/locacoes', function() {
    return view('app.locacoes');
})->name('locacoes')->middleware('auth');

Route::get('/carros', function() {
    return view('app.carros');
})->name('carros')->middleware('auth');

Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

Route::get('/modelos', function() {
    return view('app.modelos');
})->name('modelos')->middleware('auth');
