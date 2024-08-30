<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class BladeServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    Blade::directive('role', function ($expression) {
      $expression ??= '';
      $params = explode(': ', $expression, 2);

      $expression = $params[1] ?? 'Auth::user()';
      $role = $params[0] ?: 1;
      $role = User::roles[$role];

      return "<?php if ({$expression}->role >= {$role}): ?>";
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
