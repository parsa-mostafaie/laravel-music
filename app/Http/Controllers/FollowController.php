<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(FollowRequest $request, Artist $artist)
    {
        $this->user()->follow($artist);

        $artist->loadCount('followers');
        $artist->load('tracks');

        return response($artist, 200);
    }

    public function unfollow(FollowRequest $request, Artist $artist)
    {
        $this->user()->unfollow($artist);

        $artist->loadCount('followers');
        $artist->load('tracks');

        return response($artist, 200);
    }

    /**
     * Returns current user
     * 
     * @return User|\Illuminate\Support\Optional
     */
    public function user()
    {
        return optional(Auth::user());
    }
}