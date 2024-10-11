<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait Publishable
{
  protected static function bootPublishable()
  {
    static::addGlobalScope('published', function ($builder) {
      if (isA('manager'))
        return;

      $builder->whereNotNull('published_at');
    });
  }

  protected function scopePublished($builder)
  {
    $builder->whereNotNull('published_at');
  }

  public function publish()
  {
    $this->published_at = now();
    return $this->save();
  }

  public function isPublished()
  {
    return !is_null($this->published_at);
  }

  public function unpublish()
  {
    $this->published_at = null;
    return $this->save();
  }
}