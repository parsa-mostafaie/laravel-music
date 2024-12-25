<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    $this->app->bind(UserService::class, function ($app) {
      return new UserService($app->make(UserRepositoryInterface::class));
    });
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
