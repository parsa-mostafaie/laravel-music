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
    return view('dashboard');
  }

  /**
   * Show the application admin panel.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function admin()
  {
    return view('admin');
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
      }

      return to_route('dashboard');
    }

    return redirect('/');
  }
}
