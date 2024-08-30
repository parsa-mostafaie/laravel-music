<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  public function admin(UsersDataTable $dataTable)
  {
    return $dataTable->render('admin.users');
  }
}
