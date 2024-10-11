<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TracksController extends Controller
{
  public function manage(Request $request)
  {
    return Inertia::render('Manager/Tracks', [
      'artists_select' => Artist::pluck('name', 'id'),
      'currentPage' => $request->get('page'),
      'search' => $request->get('search'),
      'categories_select' => Category::pluck('name', 'id')
    ]);
  }

  protected function rules(?Track $track = null, $file = "required")
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
      'summary' => 'nullable|string',
      'lyric' => 'required|string',
      'image' => 'nullable|image|mimes:jpg,png|max:2048',
      'file' => $file . '|mimes:mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|max:30720',
      'quality' => 'required|numeric',
      'category_id' => 'required|exists:categories,id',
      'artist_id' => 'required|exists:artists,id',
    ];

    return $rules;
  }

  public function store(Request $request)
  {
    $request->validate($this->rules());

    $track = new Track;

    $track->fill($request->except(['image', 'file']));

    if (($response = $this->uploadImage($request, $track)) !== true) {
      return $response;
    }

    if (($response = $this->uploadFile($request, $track)) !== true) {
      return $response;
    }

    $track->save();

    return $track;
  }

  public function uploadImage(Request $request, Track $track)
  {
    if ($file = $request->file('image')) {
      $track->image = $file->store('cover-images', 'public');

      if ($track->image === false) {
        return response("Failed To Upload Image!", 500);
      }

      $track->removePreviousImage();
    }

    return true;
  }

  public function uploadFile(Request $request, Track $track)
  {
    if ($file = $request->file('file')) {
      $track->file = $file->store('tracks', 'public');

      $track->size = $file->getSize();

      if ($track->file == false) {
        return response("Failed To Upload Track File!", 500);
      }

      $getID3 = new \getID3;

      $finfo = $getID3->analyze(Storage::disk('public')->path($track->file));

      if (!empty($finfo['error'])) {
        return response($finfo['error'], 500);
      }

      $track->removePreviousFile();

      $track->time = round($finfo['playtime_seconds']);
    }

    return true;
  }

  public function update(Request $request, Track $track)
  {
    $request->validate($this->rules($track, 'nullable'));

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
        ->with('artist', 'category')
        ->withoutGlobalScope('published')
        ->paginate(2);
  }

  public function destroy(Track $track)
  {
    $track->delete();

    return response("Track was deleted successfully!", 204);
  }

  public function publish(Track $track)
  {
    if ($track->isPublished()) {
      return $track->unpublish();
    }

    return $track->publish();
  }
}
