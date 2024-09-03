<?php

namespace App\Http\Controllers;

use App\Models\Artist;
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

  public function create(Request $request)
  {
    $request->validate(
      [
        'name' => 'required|string|unique:artists,name'
      ]
    );

    return Artist::create($request->all());
  }

  public function get(Request $request)
  {
    return
      Artist::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->paginate(2);
  }

  public function destroy(Artist $artist)
  {
    $artist->delete();

    return response("Artist was deleted successfully!", 204);
  }
}
