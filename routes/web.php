<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackController;

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
})->name('welcome');

// custom:
Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/dashboard', [PanelController::class, 'dashboard'])
    ->name('dashboard');

  Route::prefix('admin')
    ->group(function () {
      Route::get('/', [PanelController::class, 'admin'])
        ->name('admin');
    });

  Route::prefix('manager')
    ->group(function () {
      Route::get('/users', [UserController::class, 'manage'])
        ->name('manager.users');

      Route::get('/categories', [CategoryController::class, 'manage'])
        ->name('manager.categories');

      Route::get('/artists', [ArtistController::class, 'manage'])
        ->name('manager.artists');

      Route::get('/tracks', [TrackController::class, 'manage'])
        ->name('manager.tracks');

      Route::get('/', [PanelController::class, 'manager'])
        ->name('manager');
    });
});

Route::get('artists/{artist}/{slug?}', [ArtistController::class, 'profile'])
  ->name('artists.profile');

Route::get('listen/{track}/{slug?}', [TrackController::class, 'listen'])
  ->name('tracks.listen');

Route::get('/home', PanelController::class)->name('home');
Route::get('/panel', PanelController::class);