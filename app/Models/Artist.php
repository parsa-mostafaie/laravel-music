<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Artist extends Model
{
  use Traits\HasImage;

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
  protected $appends = ['destroy_url', 'image_url', 'slug', 'profile_url', 'followed', 'follower_count'];

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

  public function getSlugAttribute()
  {
    return Str::slug($this->name);
  }

  public function getProfileUrlAttribute()
  {
    return route("artists.profile", [
      $this,
      $this->slug,
    ]);
  }

  public function followers()
  {
    return $this->hasManyThrough(User::class, Follow::class, 'followed_artist_id', 'id', 'id', 'following_user_id');
  }

  public function getFollowedAttribute(){
    /**
     * @var User|null
     */
    $user = Auth::user();

    return $user && $user->isFollowing($this);
  }

  public function getFollowerCountAttribute(){
    return $this->followers()->count();
  }
}
