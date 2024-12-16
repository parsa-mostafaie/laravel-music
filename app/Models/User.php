<?php

namespace App\Models;

use App\Models\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Follower;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, Follower, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * Attributes to append
   * 
   * @var array<int, string>
   */
  protected $appends = ['grow_url', 'shrink_url', 'role_name', 'profile_photo_url'];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public static function explode_name($name)
  {
    $parts = explode(' ', $name, 2);
    $firstname = $parts[0];
    $lastname = $parts[1] ?? '';

    return compact('firstname', 'lastname');
  }

  // public function name(): Attribute
  // {
  //   return Attribute::make(
  //     get: fn() => "$this->firstname $this->lastname",
  //     set: function ($value) {
  //       $parts = explode(' ', $value, 2);
  //       $this->firstname = $parts[0];
  //       $this->lastname = $parts[1] ?? '';
  //     }
  //   );
  // }
}
