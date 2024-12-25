<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagersOnlyRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
  public function __construct(
    protected UserService $userService
  ) {}

  public function manage(ManagersOnlyRequest $request)
  {
    return inertia('Manager/Users', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search')
    ]);
  }

  public function index(ManagersOnlyRequest $request)
  {
    return $this->userService->paginate($request->search, withCount: 'followings');
  }

  public function grow(User $user)
  {
    Gate::authorize('grow-users', [$user]);

    return $this->userService->grow($user);
  }

  public function shrink(User $user)
  {
    Gate::authorize('shrink-users', [$user]);

    return $this->userService->shrink($user);
  }
}
