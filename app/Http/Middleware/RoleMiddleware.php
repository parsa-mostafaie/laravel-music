<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $min = 1, $to = 'view'): Response
  {
    $min = User::roles[$min];

    if (!Auth::check() || Auth::user()->role < $min) {
      if (Route::has('login') && $to != 'api') {
        return to_route('login');
      }

      return response('Access Denied!', 403);
    }

    return $next($request);
  }
}
