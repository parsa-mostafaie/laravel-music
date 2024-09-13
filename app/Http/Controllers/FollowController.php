<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Artist $artist)
    {
        $this->user()->follow($artist);

        return response($artist, 200);
    }

    public function unfollow(Artist $artist)
    {
        $this->user()->unfollow($artist);

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