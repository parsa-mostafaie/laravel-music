<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistsController extends Controller
{
  public function manage(Request $request)
  {
    return view('manager.artists', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }
}
