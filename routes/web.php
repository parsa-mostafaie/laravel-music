<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
  return view('welcome');
})->name('landing');

Auth::routes(['verify' => true]);

include_once 'api.php';

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [PanelController::class, 'dashboard'])
    ->name('dashboard');

  Route::middleware('role:admin')
    ->prefix('admin')
    ->group(function () {
      Route::get('/', [PanelController::class, 'admin'])
        ->name('admin');
    });

  Route::middleware('role:manager')
    ->prefix('manager')
    ->group(function () {
      Route::get('/users', [UsersController::class, 'manage'])
        ->name('manager.users');

      Route::get('/', [PanelController::class, 'manager'])
        ->name('manager');
    });
});

Route::get('/home', PanelController::class);
Route::get('/panel', PanelController::class);