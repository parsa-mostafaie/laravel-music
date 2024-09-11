<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

  /**
   * A Array to easy convert any role type (string|number) to int
   * How? User::roles[0] = 0, User::roles['admin'] = 1, ...
   * 
   * @var array
   */
  const roles = [
    0,
    1,
    2,
    3,
    'user' => 0,
    'manager' => 1,
    'admin' => 2,
    'developer' => 3,
  ];

  const MAX_ROLE = 3;
  const MAX_SECURE_ROLE = 2;
  const MIN_ROLE = 0;

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

  public function isA($role)
  {
    $role = static::roles[$role];

    return $this->role >= $role;
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

  public function getGrowUrlAttribute()
  {
    if ($this->role >= self::MAX_SECURE_ROLE || Gate::denies('grow-users', [$this]))
      return null;

    return route('api.users.grow', ['user' => $this]);
  }

  public function getShrinkUrlAttribute()
  {
    if ($this->role <= self::MIN_ROLE || Gate::denies('shrink-users', [$this]))
      return null;

    return route('api.users.shrink', ['user' => $this]);
  }

  public function getRoleNameAttribute()
  {
    $fr = array_flip(static::roles);

    return $fr[$this->role];
  }

  public static function validateRole($role, $secure = true)
  {
    return min(max(static::roles[$role], static::MIN_ROLE), $secure ? static::MAX_SECURE_ROLE : static::MAX_ROLE);
  }
}
