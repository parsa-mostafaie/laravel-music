<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;

Route::middleware(
  config('jetstream.middleware', ['web'])
)->as('api.')->group(function () {
  Route::middleware('role:manager,api')->group(function () {
    Route::apiResource('artists', ArtistController::class);

    Route::apiResource('categories', CategoryController::class);

    // Track
    Route::apiResource('tracks', TrackController::class);

    Route::put('tracks/{track}/publish', [TrackController::class, 'publish'])
      ->name('tracks.publish');

    // User
    Route::get('users', [UserController::class, 'show'])
      ->name('users.index');

    Route::put('users/{user}/grow', [UserController::class, 'grow'])
      ->name('users.grow');

    Route::put('users/{user}/shrnk', [UserController::class, 'shrink'])
      ->name('users.shrink');
  });

  // follows
  Route::post('follow/{artist}', [FollowController::class, 'follow'])->name('follow');
  Route::post('unfollow/{artist}', [FollowController::class, 'unfollow'])->name('unfollow');
});