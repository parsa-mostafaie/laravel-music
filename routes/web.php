<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

include_once 'api.php';

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [PanelController::class, 'dashboard'])
    ->name('dashboard');

  Route::middleware('role:admin')->group(function () {
    Route::get('/admin', [PanelController::class, 'admin'])
      ->name('admin');

    Route::get('/admin/users', [UsersController::class, 'admin'])
      ->name('admin.users');
  });
});

Route::get('/home', PanelController::class);
Route::get('/panel', PanelController::class);