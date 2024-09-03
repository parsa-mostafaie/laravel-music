<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
  public function manage(Request $request)
  {
    return view('manager.users', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }

  public function grow(User $user)
  {
    Gate::authorize('grow-users', [$user]);

    User::withoutTimestamps(function () use ($user) {
      $user->role = User::validateRole($user->role + 1);
      $user->save();
    });
  }

  public function shrink(User $user)
  {
    Gate::authorize('shrink-users', [$user]);

    User::withoutTimestamps(function () use ($user) {
      $user->role = User::validateRole($user->role - 1);
      $user->save();
    });
  }

  public function get(Request $request)
  {
    return
      User::whereRaw(
        'CONCAT(users.firstname, " ", users.lastname) LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->paginate(2);
  }
}
