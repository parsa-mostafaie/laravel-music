<?php
namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
  public function getSlugAttribute()
  {
    return Str::slug($this->name);
  }
}