@extends('dashboard.index')
@section('title', 'Réclamations')

@section('content')
<a href="{{ route('reclamations.create') }}" class="btn btn-primary mb-3">Nouvelle Réclamation</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reclamations as $rec)
        <tr>
            <td>{{ $rec->id }}</td>
            <td>{{ $rec->titre }}</td>
            <td>{{ $rec->statut }}</td>
            <td>
                <a href="{{ route('reclamations.show', $rec->id) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('reclamations.edit', $rec->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('reclamations.destroy', $rec->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
