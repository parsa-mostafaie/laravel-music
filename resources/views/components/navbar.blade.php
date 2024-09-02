<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('favicon.png') }}" alt="Favicon" class="navbar-image" width="32" height="32">
      {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link @routeclass('login')" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link @routeclass('register')" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
          @endif

          <hr>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvas">
              {{__('Menu')}}
            </a>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvas">
              {{ __('Hi') }} {{ Auth::user()->firstname }} 👋
            </a>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
