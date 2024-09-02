@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">Manage Users</div>
      <div class="card-body">
        <users-table current-page="{{ $currentPage }}" search="{{$search}}"></users-table>
      </div>
    </div>
  </div>
@endsection
