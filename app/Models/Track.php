<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
  protected $table = "musics";

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [];

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
  protected $appends = [];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [];
  }
}
