<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
  public function manage(Request $request)
  {
    return view('manager.users', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }
}
