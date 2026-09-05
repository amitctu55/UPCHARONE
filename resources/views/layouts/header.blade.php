<!-- TOP HEADER / CONTACT STRIP -->
<div class="top-header bg-dark text-light py-2 fs-8">
  <div class="container d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
      <span><i class="fas fa-phone-alt text-primary me-1"></i> Emergency: <strong>1800-123-4567</strong></span>
      <span class="d-none d-md-inline"><i class="fas fa-envelope text-primary me-1"></i> support@upchar.com</span>
    </div>
    <div class="d-flex align-items-center gap-3">
      <!-- CITY SELECTOR DROPDOWN -->
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-light border-0 dropdown-toggle py-0 text-light" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-map-marker-alt text-danger me-1"></i> <span id="selectedCity">Varanasi</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm fs-7" aria-labelledby="cityDropdown">
          <li><a class="dropdown-item city-option" href="#" data-city="Varanasi">Varanasi</a></li>
          <li><a class="dropdown-item city-option" href="#" data-city="Lucknow">Lucknow</a></li>
          <li><a class="dropdown-item city-option" href="#" data-city="Delhi">Delhi</a></li>
          <li><a class="dropdown-item city-option" href="#" data-city="Mumbai">Mumbai</a></li>
        </ul>
      </div>
      <a href="/lab-tests" class="text-light text-decoration-none d-none d-sm-inline">Lab Reports</a>
    </div>
  </div>
</div>

<!-- MAIN NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
  <div class="container">
    <!-- BRAND LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <span class="fw-bold fs-3 text-primary me-1">Upchar</span>
      <span class="badge bg-soft-primary text-primary fs-8">Healthcare</span>
    </a>

    <!-- MOBILE TOGGLER BUTTON -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#upcharNavbar" aria-controls="upcharNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fas fa-bars fs-4 text-dark"></span>
    </button>

    <!-- NAVIGATION LINKS -->
    <div class="collapse navbar-collapse" id="upcharNavbar">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('doctors*') ? 'active' : '' }}" href="{{ url('/doctors') }}">Find Doctors</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('hospitals*') ? 'active' : '' }}" href="{{ url('/hospitals') }}">Hospitals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('lab-tests*') ? 'active' : '' }}" href="{{ url('/lab-tests') }}">Lab Tests</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('medicines*') ? 'active' : '' }}" href="{{ url('/medicines') }}">Medicines</a>
        </li>
      </ul>

      <!-- RIGHT ACTION BUTTONS -->
      <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
        @auth
          <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle rounded-pill px-3" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="{{ url('/dashboard') }}">My Appointments</a></li>
              <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ url('/login') }}" class="btn btn-outline-primary rounded-pill px-4 me-1">Login</a>
          <a href="{{ url('/doctors') }}" class="btn btn-primary rounded-pill px-4">Book Now</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
