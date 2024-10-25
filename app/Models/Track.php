<?php

namespace App\Models;

use App\Interfaces\HasAudioFile;
use App\Interfaces\HasImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Track extends Model implements HasImage, HasAudioFile
{
  use Traits\HasImage, Traits\HasSlug, Traits\HasAudioFile;

  use Traits\Publishable;

  protected $table = "musics";

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ['name', 'summary', 'lyric', 'quality', 'category_id', 'artist_id'];

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
  protected $appends = ['image_url', 'file_url', 'file_mime', 'time_string', 'listen_url'];

  protected $with = ['artist', 'category'];

  protected $dates = ['published_at'];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return ['quality' => 'integer'];
  }

  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function booted()
  {
  }

  public function artist()
  {
    return $this->belongsTo(Artist::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function getListenUrlAttribute()
  {
    return route('tracks.listen', [$this, $this->slug]);
  }
}
