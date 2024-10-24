<?php

namespace App\Http\Controllers;

use App\Http\Requests\TracksRequest;
use App\Http\Requests\TrackStoreRequest;
use App\Http\Requests\TrackUpdateRequest;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TrackController extends Controller
{
  use Traits\UploadsImages, Traits\UploadsMusicFiles;

  protected $image_path = 'cover-images';

  public function manage(TracksRequest $request)
  {
    return Inertia::render('Manager/Tracks', [
      'artists_select' => Artist::pluck('name', 'id'),
      'currentPage' => $request->get('page'),
      'search' => $request->get('search'),
      'categories_select' => Category::pluck('name', 'id')
    ]);
  }

  public function store(TrackStoreRequest $request)
  {
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

  public function update(TrackUpdateRequest $request, Track $track)
  {
    $track->fill($request->except(['image', 'file']));

    if (($response = $this->uploadImage($request, $track)) !== true) {
      return $response;
    }

    if (($response = $this->uploadFile($request, $track)) !== true) {
      return $response;
    }

    $track->save();

    return response($track->fresh(), 200);
  }

  public function index(TracksRequest $request)
  {
    return
      Track::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->withoutGlobalScope('published')
        ->paginate(2);
  }

  public function destroy(TracksRequest $request, Track $track)
  {
    $track->delete();

    return response("Track was deleted successfully!", 200);
  }

  public function publish(TracksRequest $request, Track $track)
  {
    if ($track->isPublished()) {
      return $track->unpublish();
    }

    return $track->publish();
  }

  public function listen(Request $request, Track $track, ?string $slug = null)
  {

    if ($slug !== $track->slug) {
      return redirect(url($track->listen_url, $request->all()));
    }

    return inertia(
      'Tracks/Single',
      [
        'track' => $track,
        'artists_select' => Artist::pluck('name', 'id'),
        'categories_select' => Category::pluck('name', 'id')
      ]
    );
  }
}
