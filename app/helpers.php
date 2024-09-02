<?php

use Illuminate\Support\Facades\Route;

function getClassForRoute($name, $class = "text-dark")
{
  if (
    Route::currentRouteName() == $name ||
    (is_array($name) && in_array(Route::currentRouteName(), $name))
  ) {
    return $class;
  }

  return '';
}
