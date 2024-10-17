<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminsOnlyRequest;
use App\Http\Requests\ManagersOnlyRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UsersOnlyRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PanelController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Show the application dashboard.
   *
   * @return \Inertia\Response
   */
  public function dashboard(UsersOnlyRequest $request)
  {
    return Inertia::render('Dashboard');
  }

  /**
   * Show the application admin panel.
   *
   * @return \Inertia\Response
   */
  public function admin(AdminsOnlyRequest $request)
  {
    return Inertia::render('Admin');
  }

  /**
   * Show the application manager panel.
   *
   * @return \Inertia\Response
   */
  public function manager(ManagersOnlyRequest $request)
  {
    return Inertia::render('Manager');
  }

  /**
   * Show A View Relative to user role
   * 
   * @return RedirectResponse
   */
  public function __invoke()
  {
    if (Auth::check()) {
      /** @var \App\Models\User */
      $current_user = Auth::user();

      if ($current_user->isA('admin')) {
        return to_route('admin');
      } else if ($current_user->isA('manager')) {
        return to_route('manager');
      }

      return to_route('dashboard');
    }

    return redirect('/');
  }
}
