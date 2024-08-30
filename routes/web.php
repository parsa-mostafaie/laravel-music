<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->name('dashboard');

  Route::get('/admin', fn() => view('admin'))
    ->middleware('role:admin')
    ->name('admin');
});

Route::get('/home', HomeController::class);