<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::middleware(
  config('jetstream.middleware', ['web'])
)->group(function () {
  Route::middleware('role:manager,api')->group(function () {
    // Artists

    Route::get('artists', [ArtistController::class, 'show'])
      ->name('api.artists');

    Route::delete('artists/{artist}', [ArtistController::class, 'destroy'])
      ->name('api.artists.destroy');

    Route::put('artists/{artist}', [ArtistController::class, 'update'])
      ->name('api.artists.update');

    Route::post('artists', [ArtistController::class, 'store'])
      ->name('api.artists.store');

    // Categories
    Route::get('categories', [CategoryController::class, 'show'])
      ->name('api.categories');

    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
      ->name('api.categories.destroy');

    Route::put('categories/{category}', [CategoryController::class, 'update'])
      ->name('api.categories.update');

    Route::post('categories', [CategoryController::class, 'store'])
      ->name('api.categories.store');

    // Track
    Route::get('tracks', [TrackController::class, 'show'])
      ->name('api.tracks');

    Route::delete('tracks/{track}', [TrackController::class, 'destroy'])
      ->name('api.tracks.destroy');

    Route::put('tracks/{track}/publish', [TrackController::class, 'publish'])
      ->name('api.tracks.publish');

    Route::put('tracks/{track}', [TrackController::class, 'update'])
      ->name('api.tracks.update');

    Route::post('tracks', [TrackController::class, 'store'])
      ->name('api.tracks.store');

    // User
    Route::get('users', [UserController::class, 'show'])
      ->name('api.users');

    Route::put('users/{user}/grow', [UserController::class, 'grow'])
      ->name('api.users.grow');

    Route::put('users/{user}/shrnk', [UserController::class, 'shrink'])
      ->name('api.users.shrink');
  });

  // follows
  Route::post('follow/{artist}', [FollowController::class, 'follow'])->name('api.follow');
  Route::post('unfollow/{artist}', [FollowController::class, 'unfollow'])->name('api.unfollow');
});