@auth
<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
    <a href="" class="navbar-brand p-0">
<img src="{{ asset('landing/img/eco.png') }}" alt="Stocker Logo" class="logo-img" style="height: 70px;">    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('campagnes.front') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Campagnes</a>
             <a href="{{ route('experiences.index') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Expériences partagées</a>
 <a href="{{ route('user.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    Mon tableau de bord
                </a>



            <a href="{{ route('reclamations.index') }}" class="nav-item nav-link {{ request()->routeIs('reclamations.index') ? 'active' : '' }}">
    Contact Us
</a>
<a href="{{ url('/ai') }}" class="nav-item nav-link {{ request()->is('ai') ? 'active' : '' }}">AI Chatbot</a>
        </div>
        <a href="#" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Get Started</a>
    </div>
</nav>
@endauth