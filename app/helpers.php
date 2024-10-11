<?php

use Illuminate\Support\Facades\Auth;

if(!function_exists('isA')){
  function isA($role = 1){
    /**
     * @var \App\Models\User
     */
    $user = Auth::user();

    return $user && $user->isA($role);
  }
}