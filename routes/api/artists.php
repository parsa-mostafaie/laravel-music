<?php

use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;

// Artists
Route::prefix('artists')->as('artists.')->group(function () {
  Route::get('/', [ArtistController::class, 'show'])
    ->name('show');

  Route::delete('/{artist}', [ArtistController::class, 'destroy'])
    ->name('destroy');

  Route::put('/{artist}', [ArtistController::class, 'update'])
    ->name('update');

  Route::post('/', [ArtistController::class, 'store'])
    ->name('store');
});