<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TracksController extends Controller
{
  public function manage(Request $request)
  {
    return Inertia::render('Manager/Tracks');
  }

  protected function rules(?Track $track = null)
  {
    $unique =
      Rule::unique('musics');

    if ($track) {
      $unique->ignore($track->id);
    }

    $rules = [
      'name' => [
        'required',
        'string',
        $unique
      ],
    ];

    return $rules;
  }

  public function store(Request $request)
  {
    $request->validate($this->rules());

    return Track::create($request->all());
  }
  public function update(Request $request, Track $track)
  {
    $request->validate($this->rules($track));

    return response(
      tap($track, fn($track) => $track->update($request->all())),
      200
    );
  }

  public function show(Request $request)
  {
    return
      Track::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->paginate(2);
  }

  public function destroy(Track $track)
  {
    $track->delete();

    return response("Track was deleted successfully!", 204);
  }
}
