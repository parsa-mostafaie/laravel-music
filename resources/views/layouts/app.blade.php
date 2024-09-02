<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link type="image/png" sizes="120x120" rel="icon" href="{{ asset('favicon.png') }}">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div id="app">
    @include('components.navbar')
    @include('components.offcanvas')

    <main class="py-4">
      @yield('content')
    </main>
  </div>
  @stack('scripts')
</body>

</html>
