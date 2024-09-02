<?php

use Illuminate\Support\Facades\Route;

function getClassForRoute($name, $class = "text-dark")
{
  if (Route::currentRouteName() == $name) {
    return $class;
  }

  return '';
}
