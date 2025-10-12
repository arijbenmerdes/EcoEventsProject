@extends('dashboard.index')
@section('title', 'Liste des événements')

@section('content')
<div class="mb-3">
    <input type="text" id="searchEvent" class="form-control" placeholder="Rechercher un événement...">
</div>

<div class="row" id="eventsContainer">
    @include('dashboard.pages.events.partials.events_cards', ['events' => $events])
</div>
<a href="{{ route('events.export.pdf') }}" class="btn btn-danger mb-3">Exporter PDF</a>
<a href="{{ route('events.export.excel') }}" class="btn btn-success mb-3">Exporter Excel</a>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchEvent');
    const eventsContainer = document.getElementById('eventsContainer');

    searchInput.addEventListener('keyup', function () {
        const query = this.value;

        fetch(`/events/search?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                eventsContainer.innerHTML = html;
            })
            .catch(error => console.error('Erreur AJAX:', error));
    });
});
</script>
@endsection
