<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanelController;

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [PanelController::class, 'dashboard'])
    ->name('dashboard');

  Route::get('/admin', [PanelController::class, 'admin'])
    ->middleware('role:admin')
    ->name('admin');
});

Route::get('/home', PanelController::class);
Route::get('/panel', PanelController::class);