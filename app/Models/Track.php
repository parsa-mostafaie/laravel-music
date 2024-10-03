<?php

namespace App\Models;

use App\Models\Traits\HasImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Track extends Model
{
  use Traits\HasImage {
    HasImage::booted as _booted;
  }

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
  protected $appends = ['image_url', 'file_url'];

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
    static::deleted(function ($model) {
      $model->_booted();
      $model->removeFile();
    });
  }

  public function getFileUrlAttribute()
  {
    return !is_null($this->file) ? Storage::url($this->file) : null;
  }

  public function removePreviousFile()
  {
    if (!($original = $this->getOriginal('file'))) {
      return true;
    }

    return Storage::disk('public')->delete($original);
  }

  public function removeFile()
  {
    if (!($path = $this->file)) {
      return true;
    }

    return Storage::disk('public')->delete($path);
  }
}
