<?php

use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::prefix('/api/')->group(
  function () {
    Route::middleware('role:manager,api')->group(function () {
      Route::get('users', [UsersController::class, 'get']);

      Route::get('artists', [ArtistsController::class, 'get']);

      Route::delete('artist/{artist}', [ArtistsController::class, 'destroy']);

      Route::post('artist', [ArtistsController::class, 'create']);

      Route::put('user/{user}/grow', [UsersController::class, 'grow'])
        ->name('api.user.grow');

      Route::put('user/{user}/shrnk', [UsersController::class, 'shrink'])
        ->name('api.user.shrink');
    });
  }
);