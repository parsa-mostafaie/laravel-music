<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

trait HasRoles
{
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

  public function isA($role)
  {
    $role = static::roles[$role];

    return $this->role >= $role;
  }

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
