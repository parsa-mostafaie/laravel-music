<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait HasAudioFile
{
  protected static function bootHasAudioFile(){
    static::deleted(function ($model) {
      $model->removeFile();
    });
  }

  public function removePreviousFile(): bool
  {
    if (!($original = $this->getOriginal('file'))) {
      return true;
    }

    return Storage::disk('public')->delete($original);
  }

  public function removeFile(): bool
  {
    if (!($path = $this->file)) {
      return true;
    }

    return Storage::disk('public')->delete($path);
  }

  public function getFileMimeAttribute(): bool|string|null
  {
    if (!$this->file) {
      return null;
    }

    return mime_content_type(Storage::disk('public')->path($this->file));
  }

  public function getTimeStringAttribute(): string
  {
    return \Carbon\CarbonInterval::seconds($this->time)->cascade()->forHumans() ?? '';
  }

  public function getFileUrlAttribute(): string|null
  {
    return !is_null($this->file) ? Storage::url($this->file) : null;
  }
}
