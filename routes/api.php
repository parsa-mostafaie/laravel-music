<?php

use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(
  config('jetstream.middleware', ['web'])
)->group(function () {
  Route::middleware('role:manager,api')->group(function () {
    Route::get('users', [UsersController::class, 'show'])
      ->name('api.users');

    Route::get('artists', [ArtistsController::class, 'show'])
      ->name('api.artists');

    Route::delete('artists/{artist}', [ArtistsController::class, 'destroy'])
      ->name('api.artists.destroy');

    Route::put('artists/{artist}', [ArtistsController::class, 'update'])
      ->name('api.artists.update');

    Route::post('artists', [ArtistsController::class, 'store'])
      ->name('api.artists.store');

    Route::put('users/{user}/grow', [UsersController::class, 'grow'])
      ->name('api.users.grow');

    Route::put('users/{user}/shrnk', [UsersController::class, 'shrink'])
      ->name('api.users.shrink');
  });
});