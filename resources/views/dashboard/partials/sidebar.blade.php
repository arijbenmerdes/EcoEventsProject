<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- Profil Utilisateur -->
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('dashboard/assets/images/faces/face1.jpg') }}" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
          <span class="text-secondary text-small">Administrateur</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <!-- Tableau de bord -->
   <li class="nav-item {{ request()->routeIs('admin.dashboard') || request()->routeIs('user.dashboard') ? 'active' : '' }}">
  <a class="nav-link" 
     href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
    <span class="menu-title">Tableau de bord</span>
    <i class="mdi mdi-view-dashboard menu-icon"></i>
  </a>
</li>


<!-- Événements -->
<li class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
  <a class="nav-link" data-bs-toggle="collapse" href="#events-menu"
     aria-expanded="{{ request()->routeIs('events.*') ? 'true' : 'false' }}"
     aria-controls="events-menu">
    <span class="menu-title">Événements</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-calendar-multiple menu-icon"></i>
  </a>
  <div class="collapse {{ request()->routeIs('events.*') ? 'show' : '' }}" id="events-menu">
    <ul class="nav flex-column sub-menu">
      
      <li class="nav-item {{ request()->routeIs('events.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('events.create') }}">Créer un événement</a>
      </li>
    </ul>
  </div>
</li>


    <!-- Campagnes -->
    <li class="nav-item {{ request()->routeIs('campaigns.*', 'targets.*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#campaigns-menu"
         aria-expanded="{{ request()->routeIs('campaigns.*', 'targets.*') ? 'true' : 'false' }}"
         aria-controls="campaigns-menu">
        <span class="menu-title">Campagnes</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-bullhorn menu-icon"></i>
      </a>
      <div class="collapse {{ request()->routeIs('campaigns.*', 'targets.*') ? 'show' : '' }}" id="campaigns-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ request()->routeIs('campaigns.*') && !request()->routeIs('targets.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('campaigns.index') }}">Campagnes</a>
          </li>
          <li class="nav-item {{ request()->routeIs('targets.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('targets.index') }}">Cibles</a>
          </li>
        </ul>
      </div>
    </li>
     <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">







<!--reclamation et reponse  -->
    <li class="nav-item {{ request()->routeIs('reclamations.*', 'reponses.*') ? 'active' : '' }}">
  <a class="nav-link" data-bs-toggle="collapse" href="#reclamations-menu"
     aria-expanded="{{ request()->routeIs('reclamations.*', 'reponses.*') ? 'true' : 'false' }}"
     aria-controls="reclamations-menu">
    <span class="menu-title">Réclamations</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-bullhorn menu-icon"></i>
  </a>
  <div class="collapse {{ request()->routeIs('reclamations.*', 'reponses.*') ? 'show' : '' }}" id="reclamations-menu">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item {{ request()->routeIs('reclamations.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reclamations.index') }}">Réclamations</a>
      </li>

      <li class="nav-item {{ request()->routeIs('reponses.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reponses.index') }}">Réponses</a>
      </li>
    </ul>
  </div>
</li>


    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('landing') }}">
        <span class="menu-title">Home</span>
<i class="mdi mdi-home-variant menu-icon"></i>      </a>
    </li>

    <!-- Déconnexion -->
    <!-- Déconnexion -->
<li class="nav-item">
  <a class="nav-link" href=""
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <span class="menu-title">Déconnexion</span>
    <i class="mdi mdi-logout menu-icon"></i>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</li>

  </ul>
</nav>
