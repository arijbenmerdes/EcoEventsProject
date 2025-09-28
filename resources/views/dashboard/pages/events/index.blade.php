@extends('dashboard.index')

@section('content')
<div class="container">
    <h1>Liste des événements</h1>

    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Créer un événement</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Actions</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->start_date }}</td>
            <td>{{ $event->end_date }}</td>
            <td>
                <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
