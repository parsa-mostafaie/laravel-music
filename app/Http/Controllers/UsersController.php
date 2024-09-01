<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
  public function admin(Request $request)
  {
    return view('admin.users', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }
}
