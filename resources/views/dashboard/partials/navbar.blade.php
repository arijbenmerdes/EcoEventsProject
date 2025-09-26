<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo" href="">
      <img src="{{ asset('dashboard/assets/images/logo.svg') }}" alt="logo">
    </a>
    <a class="navbar-brand brand-logo-mini" href="">
      <img src="{{ asset('dashboard/assets/images/logo-mini.svg') }}" alt="logo">
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

    <!-- Menu de navigation droite -->
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-text">
            <span class="font-weight-bold mb-2">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
            <span class="text-secondary text-small">Administrateur</span>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-account me-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href=""
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout me-2"></i> Déconnexion
          </a>
        </div>
      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
