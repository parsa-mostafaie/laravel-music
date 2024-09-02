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
      $role = $params[0] ?: 'admin';
      $role = User::validateRole($role);

      return "<?php if ({$expression}->role >= {$role}): ?>";
    });

    Blade::directive('endrole', function () {
      return "<?php endif; ?>";
    });

    Blade::directive('routeclass', function ($expression) {
      return "<?php echo getClassForRoute($expression); ?>";
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
