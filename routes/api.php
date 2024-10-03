<?php

use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TracksController;
use Illuminate\Support\Facades\Route;

Route::middleware(
  config('jetstream.middleware', ['web'])
)->group(function () {
  Route::middleware('role:manager,api')->group(function () {
    // Artists

    Route::get('artists', [ArtistsController::class, 'show'])
      ->name('api.artists');

    Route::delete('artists/{artist}', [ArtistsController::class, 'destroy'])
      ->name('api.artists.destroy');

    Route::put('artists/{artist}', [ArtistsController::class, 'update'])
      ->name('api.artists.update');

    Route::post('artists', [ArtistsController::class, 'store'])
      ->name('api.artists.store');

    // Categories
    Route::get('categories', [CategoriesController::class, 'show'])
      ->name('api.categories');

    Route::delete('categories/{category}', [CategoriesController::class, 'destroy'])
      ->name('api.categories.destroy');

    Route::put('categories/{category}', [CategoriesController::class, 'update'])
      ->name('api.categories.update');

    Route::post('categories', [CategoriesController::class, 'store'])
      ->name('api.categories.store');

    // Track
    Route::get('tracks', [TracksController::class, 'show'])
      ->name('api.tracks');

    Route::delete('tracks/{track}', [TracksController::class, 'destroy'])
      ->name('api.tracks.destroy');

    Route::put('tracks/{track}', [TracksController::class, 'update'])
      ->name('api.tracks.update');

    Route::post('tracks/{track}', [TracksController::class, 'update'])
      ->name('api.tracks.store');

    // User
    Route::get('users', [UsersController::class, 'show'])
      ->name('api.users');

    Route::put('users/{user}/grow', [UsersController::class, 'grow'])
      ->name('api.users.grow');

    Route::put('users/{user}/shrnk', [UsersController::class, 'shrink'])
      ->name('api.users.shrink');
  });

  // follows
  Route::post('follow/{artist}', [FollowController::class, 'follow'])->name('api.follow');
  Route::post('unfollow/{artist}', [FollowController::class, 'unfollow'])->name('api.unfollow');
});