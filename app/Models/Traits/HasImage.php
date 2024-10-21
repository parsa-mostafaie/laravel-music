<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function bootHasImage()
  {
    static::deleted(function ($model) {
      $model->removeImage();
    });
  }

  public function getImageUrlAttribute(): string|null
  {
    return !is_null($this->image) ? Storage::url($this->image) : null;
  }

  public function removePreviousImage(): bool
  {
    if (!($original = $this->getOriginal('image'))) {
      return true;
    }

    return Storage::disk('public')->delete($original);
  }

  public function removeImage(): bool
  {
    if (!($path = $this->image)) {
      return true;
    }

    return Storage::disk('public')->delete($path);
  }
}