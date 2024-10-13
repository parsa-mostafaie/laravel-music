<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::middleware(
  config('jetstream.middleware', ['web'])
)->as('api.')->group(function () {
  Route::middleware('role:manager,api')->group(function () {
    include_once 'api/artists.php';

    // Categories
    Route::get('categories', [CategoryController::class, 'show'])
      ->name('categories');

    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
      ->name('categories.destroy');

    Route::put('categories/{category}', [CategoryController::class, 'update'])
      ->name('categories.update');

    Route::post('categories', [CategoryController::class, 'store'])
      ->name('categories.store');

    // Track
    Route::get('tracks', [TrackController::class, 'show'])
      ->name('tracks');

    Route::delete('tracks/{track}', [TrackController::class, 'destroy'])
      ->name('tracks.destroy');

    Route::put('tracks/{track}/publish', [TrackController::class, 'publish'])
      ->name('tracks.publish');

    Route::put('tracks/{track}', [TrackController::class, 'update'])
      ->name('tracks.update');

    Route::post('tracks', [TrackController::class, 'store'])
      ->name('tracks.store');

    // User
    Route::get('users', [UserController::class, 'show'])
      ->name('users');

    Route::put('users/{user}/grow', [UserController::class, 'grow'])
      ->name('users.grow');

    Route::put('users/{user}/shrnk', [UserController::class, 'shrink'])
      ->name('users.shrink');
  });

  // follows
  Route::post('follow/{artist}', [FollowController::class, 'follow'])->name('follow');
  Route::post('unfollow/{artist}', [FollowController::class, 'unfollow'])->name('unfollow');
});