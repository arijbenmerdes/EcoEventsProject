@extends('user.dashboard')
@section('title', 'Liste des événements')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Liste des événements</h2>

    <!-- Champ de recherche -->
    <div class="mb-3">
        <input type="text" id="searchEventUser" class="form-control" placeholder="Rechercher un événement...">
    </div>

    <!-- Conteneur des cartes -->
    <div class="row" id="userEventsContainer">
        @include('user.events.partials.events_cards', ['events' => $events])
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchEventUser');
    const eventsContainer = document.getElementById('userEventsContainer');

    searchInput.addEventListener('keyup', function () {
        const query = this.value.trim();
        fetch(`/user/events/search?query=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => eventsContainer.innerHTML = html)
            .catch(error => console.error('Erreur AJAX :', error));
    });
});
</script>
@endsection
