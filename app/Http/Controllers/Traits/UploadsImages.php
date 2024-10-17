<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait UploadsImages
{
  public function uploadImage(Request $request, Model $model)
  {
    if ($file = $request->file('image')) {
      $model->image = $file->store($this->getImagePath(), 'public');

      if ($model->image === false) {
        return response("Failed To Upload Image!", 500);
      }

      $model->removePreviousImage();
    }

    return true;
  }

  public function getImagePath(){
    if(property_exists($this, 'image_path')){
      return $this->image_path;
    }

    return 'images';
  }
}