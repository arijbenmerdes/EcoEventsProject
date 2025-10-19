@foreach($events as $event)
<div class="col-md-4 mb-4 event-card">
    <div class="card h-100">
        @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
        @else
            <img src="https://via.placeholder.com/400x200?text=Événement" class="card-img-top" alt="placeholder">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $event->title }}</h5>
            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
            <p class="card-text"><strong>Participants :</strong> {{ $event->participants_count ?? 0 }}</p>
            <p class="card-text">
                <strong>Dates :</strong>
                {{ optional($event->start_date)->format('d/m/Y') }} -
                {{ optional($event->end_date)->format('d/m/Y') ?? 'Non défini' }}
            </p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">Voir</a>
            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Modifier</a>
        </div>
    </div>
</div>
@endforeach
