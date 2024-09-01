<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Gate::define('grow-users', function (User $user, $other) {
      $next_role = User::validateRole($other->role + 1);

      return
        $user->isNot($other)
        && $user->role > $other->role
        && $user->role > $next_role;
    });

    Gate::define('shrink-users', function (User $user, $other) {
      $next_role = User::validateRole($other->role - 1);

      return
        $user->isNot($other)
        && $user->role > $other->role
        && $user->role > $next_role;
    });
  }
}
