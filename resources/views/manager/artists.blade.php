@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">Manage Artists</div>
      <div class="card-body">
        <artists-table current-page="{{ $currentPage }}" search="{{ $search }}"></artists-table>
      </div>
    </div>
  </div>
@endsection
