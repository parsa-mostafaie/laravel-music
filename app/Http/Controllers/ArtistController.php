<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistsRequest;
use App\Http\Requests\ArtistStoreRequest;
use App\Http\Requests\ArtistUpdateRequest;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ArtistController extends Controller
{
  use Traits\UploadsImages;

  protected $image_path = 'artist-images';

  public function manage(ArtistsRequest $request)
  {
    return Inertia::render('Manager/Artists', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }

  public function store(ArtistStoreRequest $request)
  {
    $artist = new Artist;

    $artist->fill($request->all(['name', 'bio']));

    $this->uploadImage($request, $artist);

    $artist->save();

    return $artist;
  }

  public function update(ArtistUpdateRequest $request, Artist $artist)
  {
    $artist->fill($request->all(['name', 'bio']));

    $this->uploadImage($request, $artist);

    $artist->save();

    return response($artist, 200);
  }

  public function index(ArtistsRequest $request)
  {
    return
      Artist::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->withCount('followers')
        ->paginate(2);
  }

  public function destroy(ArtistsRequest $request, Artist $artist)
  {
    $artist->delete();

    return response("Artist was deleted successfully!", 200);
  }

  public function profile(Request $request, Artist $artist, ?string $slug = '')
  {
    if ($slug !== $artist->slug) {
      return redirect(url($artist->profile_url, $request->all()));
    }

    $artist->loadCount('followers');
    $artist->load('latest_tracks');

    return inertia('Artists/Profile')
      ->with('artist', $artist)
      ->with([
        'artists_select' => Artist::pluck('name', 'id'),
        'categories_select' => Category::pluck('name', 'id')
      ]);
  }
}
