<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = "categories";

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ['name', 'parent_id'];

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
  protected $appends = ['destroy_url'];

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
    return route('api.categories.destroy', [$this]);
  }

  public function parent()
  {
    return $this->belongsTo(static::class, 'parent_id');
  }

  public function childrens()
  {
    return $this->hasMany(static::class, 'parent_id');
  }
}
