@extends('landing.index')

@section('title', 'Stocker - Stock Market Website Template')

@section('content')
<!-- Navbar & Hero Start -->
<div class="container-fluid position-relative p-0">
        @include('landing.partials.navbar')

    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="{{ asset('landing/img/save-earth.jpg') }}" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row gy-0 gx-5">
                        <div class="col-lg-0 col-xl-5"></div>
                        <div class="col-xl-7 animated fadeInLeft">
                        <div class="text-sm-center text-md-end">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Bienvenue sur EcoEvents</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">Agissons ensemble pour notre planète</h1>
                                <p class="mb-5 fs-5">Rejoignez notre communauté engagée pour participer à des événements écologiques près de chez vous. Ensemble, faisons la différence pour un avenir durable et respectueux de l'environnement.</p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="https://www.youtube.com/watch?v=nCtSYKHCCAU">
                                        <i class="fas fa-play-circle me-2"></i> Voir la vidéo
                                    </a>
                                    <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">
                                        Découvrir les événements
                                    </a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <h2 class="text-white me-2">Suivez-nous :</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        <a class="btn btn-md-square btn-light rounded-circle me-2" href="">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href="">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href="">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a class="btn btn-md-square btn-light rounded-circle ms-2" href="">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="{{ asset('landing/img/tech-eco.png') }}" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-12 animated fadeInUp">
                            <div class="text-center">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Welcome To Stocker</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">Invest your money with higher return</h1>
                                <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy...</p>
                                <div class="d-flex justify-content-center flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#"><i class="fas fa-play-circle me-2"></i> Watch Video</a>
                                    <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">Learn More</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <h2 class="text-white me-2">Follow Us:</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        <a class="btn btn-md-square btn-light rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i class="fab fa-instagram"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle ms-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->

<!-- About Start -->
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                <div>
    <h4 class="text-primary">À propos de nous</h4>
    <h1 class="display-5 mb-4">Notre engagement pour une planète plus verte</h1>
    <p class="mb-4">EcoEvents est une plateforme communautaire dédiée à la promotion d'événements écologiques. Nous connectons les passionnés de l'environnement et facilitons l'organisation d'actions concrètes pour notre planète.</p>
    <div class="row g-4">
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="d-flex">
                <div><i class="fas fa-leaf fa-3x text-primary"></i></div>
                <div class="ms-4">
                    <h4>Événements Écoresponsables</h4>
                    <p>Des activités respectueuses de l'environnement partout en Tunisie</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="d-flex">
                <div><i class="fas fa-users fa-3x text-primary"></i></div>
                <div class="ms-4">
                    <h4>Communauté Engagée</h4>
                    <p>Plus de 10,000 membres actifs qui agissent pour l'environnement</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <a href="#" class="btn btn-primary rounded-pill py-3 px-5 flex-shrink-0">Découvrir nos actions</a>
        </div>
        <div class="col-sm-6">
            <div class="d-flex">
                <i class="fas fa-calendar-alt fa-2x text-primary me-4"></i>
                <div>
                    <h4>Prochain événement</h4>
                    <p class="mb-0 fs-5" style="letter-spacing: 1px;">Nettoyage citoyen - Samedi</p>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
            <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                <div class="bg-primary rounded position-relative overflow-hidden">
                    <img src="{{ asset('landing/img/save.jpg') }}" class="img-fluid rounded w-100" alt="">
                    <!-- <div class="" style="position: absolute; top: -15px; right: -15px;">
                        <img src="{{ asset('landing/img/save-2.jpg') }}" class="img-fluid" style="width: 150px; height: 150px; opacity: 0.7;" alt="">
                    </div> -->
                    <!-- <div class="" style="position: absolute; top: -20px; left: 10px; transform: rotate(90deg);">
                        <img src="{{ asset('landing/img/save2.jpg') }}" class="img-fluid" style="width: 100px; height: 150px; opacity: 0.9;" alt="">
                    </div> -->
                    <div class="rounded-bottom">
                        <img src="{{ asset('landing/img/save2.jpg') }}" class="img-fluid rounded-bottom w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Services Start -->
<div class="container-fluid service pb-5">
    <div class="container pb-5">
    <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
        <h4 class="text-primary">Nos Services</h4>
        <h1 class="display-5 mb-4">Des solutions écologiques innovantes</h1>
        <p class="mb-0">Découvrez nos services complets dédiés à la promotion d'événements écologiques et à la sensibilisation environnementale pour un impact maximal.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="service-item">
                <div class="service-img">
                    <img src="{{ asset('landing/img/service1.png') }}" class="img-fluid rounded-top w-100" alt="Gestion d'événements" style="width: 600px; height:300px;">
                </div>
                <div class="rounded-bottom p-4">
                    <a href="#" class="h4 d-inline-block mb-4">Gestion des Événements</a>
                    <p class="mb-4">Organisation complète d'événements écologiques : logistique, planning, mobilisation des participants et suivi environnemental.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">En savoir plus</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
            <div class="service-item">
                <div class="service-img">
                    <img src="{{ asset('landing/img/service2.png') }}" class="img-fluid rounded-top w-100" alt="Campagne de sensibilisation" style="width: 600px; max-height:300px;">
                </div>
                <div class="rounded-bottom p-4">
                    <a href="#" class="h4 d-inline-block mb-4">Campagnes de Sensibilisation</a>
                    <p class="mb-4">Stratégies de communication ciblées pour différents publics avec des outils pédagogiques adaptés à chaque audience.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">En savoir plus</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
            <div class="service-item">
                <div class="service-img">
                    <img src="{{ asset('landing/img/service3.jpg') }}" class="img-fluid rounded-top w-100" alt="Support écologique"  style="width: 600px; height:300px;">
                </div>
                <div class="rounded-bottom p-4">
                    <a href="#" class="h4 d-inline-block mb-4">Accompagnement Écologique</a>
                    <p class="mb-4">Conseil et soutien pour les porteurs de projets environnementaux, de l'idée à la réalisation concrète.</p>
                    <a class="btn btn-primaryrounded-pill py-2 px-4" href="#">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Services End -->

<!-- Features Start -->
<div class="container-fluid feature pb-5">
    <div class="container pb-5">
     <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
    <h4 class="text-primary">Notre Vision</h4>
    <h1 class="display-5 mb-4">Chaque geste compte, chaque événement transforme</h1>
    <p class="mb-0">Nous croyons en la puissance collective pour créer un changement durable. Notre plateforme rend l'action écologique accessible à tous.</p>
</div>
        <div class="row g-4">
            <!-- Features content -->
        </div>
    </div>
</div>
<!-- Features End -->

<!-- Other sections... -->
@endsection
