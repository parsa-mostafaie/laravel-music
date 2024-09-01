@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">Manage Users</div>
      <div class="card-body">
        <vue-users-table current-page="{{ $currentPage }}" search="{{$search}}"></vue-users-table>
      </div>
    </div>
  </div>
@endsection
