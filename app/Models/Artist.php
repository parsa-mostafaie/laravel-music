<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Artist extends Model
{
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
  protected $appends = ['destroy_url', 'image_url'];

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

  public function getImageUrlAttribute()
  {
    return !is_null($this->image) ? Storage::url($this->image) : null;
  }

  public function removePreviousImage()
  {
    if (!($original = $this->getOriginal('image'))) {
      return true;
    }

    return Storage::disk('public')->delete($original);
  }

  public function removeImage()
  {
    if (!($path = $this->image)) {
      return true;
    }

    return Storage::disk('public')->delete($path);
  }

  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function booted()
  {
    static::deleted(function ($artist) {
      $artist->removeImage();
    });
  }
}
