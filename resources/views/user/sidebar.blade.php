<!-- resources/views/user/sidebar.blade.php -->

<div class="sidebar">
    <h4 class="text-center mb-4"><i class="fa fa-user me-2"></i>Dashboard</h4>

    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fa fa-home me-2"></i>Accueil
    </a>

    <a href="{{ route('user.events.index') }}" class="{{ request()->routeIs('user.events.index') ? 'active' : '' }}">
        <i class="fa fa-calendar me-2"></i>Événements
    </a>
    <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar') ? 'active' : '' }}">
    <i class="fa fa-calendar-check me-2"></i>Calendrier
</a>

    <a href="#"><i class="fa fa-ticket me-2"></i>Mes Réservations</a>
    <a href="#"><i class="fa fa-user-cog me-2"></i>Profil</a>
    <a href="#"><i class="fa fa-cog me-2"></i>Paramètres</a>

   <a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt"></i> Déconnexion
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</div>
