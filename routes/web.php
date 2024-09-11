<?php

use App\Http\Controllers\ArtistsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

// custom:
Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
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

      Route::get('/artists', [ArtistsController::class, 'manage'])
        ->name('manager.artists');

      Route::get('/', [PanelController::class, 'manager'])
        ->name('manager');
    });
});

Route::get('/home', PanelController::class)->name('home');
Route::get('/panel', PanelController::class);