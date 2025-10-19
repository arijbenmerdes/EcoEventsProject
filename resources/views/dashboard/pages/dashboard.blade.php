@extends('dashboard.index')

@section('title', 'Tableau de Bord - EcoEvents')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-leaf"></i>
        </span> Tableau de Bord EcoEvents
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Aperçu général <i class="mdi mdi-chart-areaspline icon-sm text-gradient-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<!-- Cartes de statistiques -->
<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-primary card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Événements Actifs <i class="mdi mdi-calendar-multiple mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">15</h2>
                <h6 class="card-text">+3 cette semaine</h6>
            </div>
        </div>
    </div>

    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Participants <i class="mdi mdi-account-group mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">1,248</h2>
                <h6 class="card-text">+128 cette semaine</h6>
            </div>
        </div>
    </div>

    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Impact CO₂ <i class="mdi mdi-earth mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">2.5T</h2>
                <h6 class="card-text">Réduit ce mois</h6>
            </div>
        </div>
    </div>

    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Déchets Collectés <i class="mdi mdi-recycle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">850kg</h2>
                <h6 class="card-text">+150kg cette semaine</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Graphique des événements -->
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <h4 class="card-title float-start">Activité des Événements</h4>
                    <div class="float-end">
                        <select class="form-select form-select-sm">
                            <option>7 derniers jours</option>
                            <option>30 derniers jours</option>
                            <option>3 derniers mois</option>
                        </select>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="events-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Événements à venir -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Événements à Venir</h4>
                <div class="list-wrapper">
                    <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li class="completed">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox" checked> Nettoyage Plage
                                </label>
                            </div>
                            <i class="remove mdi mdi-close-circle-outline"></i>
                            <span class="badge badge-gradient-primary">Demain</span>
                        </li>
                        <li>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox"> Plantation d'arbres
                                </label>
                            </div>
                            <i class="remove mdi mdi-close-circle-outline"></i>
                            <span class="badge badge-warning">Samedi</span>
                        </li>
                        <li>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox"> Atelier Recyclage
                                </label>
                            </div>
                            <i class="remove mdi mdi-close-circle-outline"></i>
                            <span class="badge badge-info">Dimanche</span>
                        </li>
                    </ul>
                </div>
                <div class="add-items d-flex mb-0 mt-2">
                    <input type="text" class="form-control todo-list-input" placeholder="Nouvel événement">
                    <button class="add btn btn-gradient-success font-weight-bold todo-list-add-btn" id="add-task">+</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Actions Rapides</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="mdi mdi-calendar-plus mdi-48px text-gradient-primary"></i>
                                <h6 class="mt-3">Créer un Événement</h6>
                                <a href="#" class="btn btn-sm btn-gradient-primary mt-2">Commencer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="mdi mdi-chart-bar mdi-48px text-info"></i>
                                <h6 class="mt-3">Voir les Statistiques</h6>
                                <a href="#" class="btn btn-sm btn-info mt-2">Explorer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="mdi mdi-account-group mdi-48px text-warning"></i>
                                <h6 class="mt-3">Gérer les Participants</h6>
                                <a href="#" class="btn btn-sm btn-warning mt-2">Gérer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="mdi mdi-file-document mdi-48px text-gradient-primary"></i>
                                <h6 class="mt-3">Rapports Mensuels</h6>
                                <a href="#" class="btn btn-sm btn-gradient-primary mt-2">Générer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Script pour le graphique des événements
    if ($('#events-chart').length) {
        var ctx = document.getElementById('events-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Événements créés',
                    data: [12, 19, 3, 5, 2, 3, 15],
                    borderColor: '#00d084',
                    backgroundColor: 'rgba(0, 208, 132, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
