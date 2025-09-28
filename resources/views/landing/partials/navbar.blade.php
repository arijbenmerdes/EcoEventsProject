<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
    <a href="" class="navbar-brand p-0">
<img src="{{ asset('landing/img/eco.png') }}" alt="Stocker Logo" class="logo-img" style="height: 70px;">    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="" class="nav-item nav-link {{ request()->routeIs('service') ? 'active' : '' }}">Services</a>
            <a href="" class="nav-item nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">Blogs</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs(['feature', 'team', 'testimonial', 'offer', 'FAQ', '404']) ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <span>Pages</span>
                </a>
                <div class="dropdown-menu m-0">
                    <a href="" class="dropdown-item">Our Features</a>
                    <a href="" class="dropdown-item">Our team</a>
                    <a href="" class="dropdown-item">Testimonial</a>
                    <a href="" class="dropdown-item">Our offer</a>
                    <a href="" class="dropdown-item">FAQs</a>
                    <a href="" class="dropdown-item">404 Page</a>
                </div>
            </div>
            <a href="" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        </div>
        <a href="#" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Get Started</a>
    </div>
</nav>
