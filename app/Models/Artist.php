<?php

namespace App\Models;

use App\Interfaces\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Overtrue\LaravelFollow\Traits\Followable;

class Artist extends Model implements HasImage
{
  use Traits\HasImage, Followable, Traits\HasSlug;

  protected $alt_image_size = "1000x1000";

  protected $table = "artists";

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'image',
    'bio'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [];

  /**
   * Attributes to append
   * 
   * @var array<int, string>
   */
  protected $appends = ['destroy_url', 'image_url', 'slug', 'profile_url', 'followed', 'tracks_count'];

  const UPDATED_AT = null;

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [];
  }

  public function getDestroyUrlAttribute()
  {
    return route('api.artists.destroy', [$this]);
  }

  public function getProfileUrlAttribute()
  {
    return route("artists.profile", [
      $this,
      $this->slug,
    ]);
  }

  public function getFollowedAttribute(){
    /**
     * @var App\Models\User|null
     */
    $user = Auth::user();

    return $user && $user->isFollowing($this);
  }

  public function tracks(){
    return $this->hasMany(Track::class);
  }

  public function getTracksCountAttribute(){
    return $this->tracks()->count();
  }
}
