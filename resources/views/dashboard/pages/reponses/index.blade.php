@extends('dashboard.index')

@section('title', 'Réponses')

@section('content')
<a href="{{ route('reponses.create') }}" class="btn btn-primary mb-3">Nouvelle Réponse</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Réclamation</th>
            <th>Contenu</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reponses as $rep)
        <tr>
            <td>{{ $rep->id }}</td>
            <td>{{ $rep->reclamation->titre }}</td>
            <td>{{ $rep->contenu }}</td>
            <td>
                <a href="{{ route('reponses.show', $rep->id) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('reponses.edit', $rep->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('reponses.destroy', $rep->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
