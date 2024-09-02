<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      @role(admin)
        <li class="nav-item">
          <a href="{{ route('admin') }}" class="nav-link @routeclass('admin')">
            {{ __('Admin') }}
          </a>
        </li>
      @endrole

      @role(manager)
        <li class="nav-item">
          <a href="{{ route('manager') }}" class="nav-link @routeclass('manager')">
            {{ __('Manager') }}
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('manager.users') }}" class="nav-link @routeclass('manager.users')">
            {{ __('Manage Users') }}
          </a>
        </li>
      @endrole
      @auth
        <li class="nav-item">
          <a class="nav-link @routeclass('dashboard')" href="{{ route('dashboard') }}">
            {{ __('Dasboard') }}
          </a>
        </li>
        <hr class="nav-divider">
        <li class="nav-item">
          <a class="text-danger nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left me-2"></i> {{ __('Logout') }}
          </a>
        </li>
      @endauth
    </ul>

    @auth
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    @endauth
  </div>
</div>
