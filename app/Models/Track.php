<?php

namespace App\Models;

use App\Interfaces\HasImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Track extends Model implements HasImage
{
  use Traits\HasImage;

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
  protected $appends = ['image_url', 'file_url', 'file_mime', 'time_string'];

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
    static::deleted(function ($model) {
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

  public function artist()
  {
    return $this->belongsTo(Artist::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function getFileMimeAttribute()
  {
    if (!$this->file) {
      return null;
    }

    return mime_content_type(Storage::disk('public')->path($this->file));
  }

  public function getTimeStringAttribute(){
    return \Carbon\CarbonInterval::seconds($this->time)->cascade()->forHumans() ?? '';
  }
}
