<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function dashboard()
  {
    return view('dashboard.index');
  }

  /**
   * Show the application admin panel.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function admin()
  {
    return view('admin.index');
  }

  /**
   * Show the application manager panel.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function manager()
  {
    return view('manager.index');
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
