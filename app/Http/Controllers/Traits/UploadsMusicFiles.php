<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadsMusicFiles
{
  public function uploadFile(Request $request, Model $model)
  {
    if ($file = $request->file('file')) {
      $model->file = $file->store($this->getMusicPath(), 'public');

      $model->size = $file->getSize();

      if ($model->file == false) {
        return response("Failed To Upload Track File!", 500);
      }

      $getID3 = new \getID3;

      $finfo = $getID3->analyze(Storage::disk('public')->path($model->file));

      if (!empty($finfo['error'])) {
        return response($finfo['error'], 500);
      }

      $model->removePreviousFile();

      $model->time = round($finfo['playtime_seconds']);
    }

    return true;
  }

  function getMusicPath()
  {
    if (property_exists($this, 'music_path')) {
      return $this->music_path;
    }

    return 'tracks';
  }
}