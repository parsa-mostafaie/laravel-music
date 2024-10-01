<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ArtistsController extends Controller
{
  public function manage(Request $request)
  {
    return Inertia::render('Manager/Artists', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(
      [
        'name' => 'required|string|unique:artists,name',
        'image' => 'nullable|image|mimes:jpg,png|max:2048',
        'bio' => 'nullable|string'
      ]
    );

    $artist = new Artist;

    $artist->fill($request->all(['name', 'bio']));

    $this->uploadImage($request, $artist);

    $artist->save();

    return $artist;
  }

  public function update(Request $request, Artist $artist)
  {
    $request->validate(
      [
        'name' => [
          'required',
          'string',
          Rule::unique('artists')->ignore($artist->id)
        ],
        'image' => 'nullable|image|mimes:jpg,png|max:2048',
        'bio' => 'nullable|string'
      ]
    );

    $artist->fill($request->all(['name', 'bio']));

    $this->uploadImage($request, $artist);

    $artist->save();

    return response($artist, 200);
  }

  public function uploadImage(Request $request, Artist $artist)
  {
    if ($file = $request->file('image')) {
      $artist->image = $file->store('artist-images', 'public');

      if ($artist->image === false) {
        return response("Failed To Upload Image!", 500);
      }

      $artist->removePreviousImage();
    }
  }

  public function show(Request $request)
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

  public function profile(Request $request, Artist $artist, ?string $slug = '')
  {
    if ($slug !== $artist->slug) {
      return redirect(url($artist->profile_url, $request->all()));
    }

    return inertia('Artists/Profile')
      ->with('artist', $artist);
  }
}
