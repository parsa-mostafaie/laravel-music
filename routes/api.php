<?php

use App\Models\User;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::prefix('/api/')->group(
  function () {
    Route::middleware('role:manager,api')->group(function () {
      Route::get('users', function (Request $request) {
        return
          User::whereRaw(
            'CONCAT(users.firstname, " ", users.lastname) LIKE ?',
            ["%{$request->get('search')}%"]
          )
            ->paginate(2);
      });

      Route::get('artists', function (Request $request) {
        return
          Artist::whereRaw(
            'name LIKE ?',
            ["%{$request->get('search')}%"]
          )
            ->paginate(2);
      });

      Route::put('user/{user}/grow', function (User $user) {
        Gate::authorize('grow-users', [$user]);

        User::withoutTimestamps(function () use ($user) {
          $user->role = User::validateRole($user->role + 1);
          $user->save();
        });
      })->name('api.user.grow');

      Route::put('user/{user}/shrnk', function (User $user) {
        Gate::authorize('shrink-users', [$user]);

        User::withoutTimestamps(function () use ($user) {
          $user->role = User::validateRole($user->role - 1);
          $user->save();
        });
      })->name('api.user.shrink');
    });
  }
);