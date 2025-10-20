@extends('user.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">{{ $event->title }}</h2>

    @if($event->image)
        <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid mb-3 rounded" alt="{{ $event->title }}">
    @endif

    <p><strong>Description :</strong> {{ $event->description ?? 'Aucune' }}</p>
    <p><strong>Participants :</strong> {{ $event->participants_count ?? 0 }}</p>
    <p><strong>Date de début :</strong> {{ optional($event->start_date)->format('d/m/Y H:i') }}</p>
    <p><strong>Date de fin :</strong> {{ optional($event->end_date)->format('d/m/Y H:i') ?? 'Non précisée' }}</p>
    <p><strong>Lieu :</strong> {{ $event->location ?? 'Non précisé' }}</p>

    <a href="{{ route('user.events.index') }}" class="btn btn-secondary mt-3">Retour</a>

    <hr>

    <h4>Commentaires</h4>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulaire commentaire -->
<form action="{{ route('user.events.comment', $event->id) }}" method="POST" class="mb-4">
        @csrf
        <!-- Nom automatique de l'utilisateur connecté -->
        <input type="hidden" name="user_name" value="{{ Auth::user()->name ?? 'Utilisateur' }}">

        <div class="mb-2">
            <textarea name="comment" class="form-control" placeholder="Votre commentaire" required></textarea>
        </div>
        <div class="mb-2">
            <select name="rating" class="form-control">
                <option value="">Note (optionnelle)</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}">{{ $i }} étoiles</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <!-- Liste des commentaires -->
   @foreach($event->comments as $comment)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $comment->user_name }}</strong>
            @if($comment->rating) - {{ $comment->rating }} ⭐ @endif
            <p>{{ $comment->comment }}</p>
            <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>

            @if($comment->user_name === Auth::user()->name)
                <div class="mt-2">
                    <a href="{{ route('user.events.comment.edit', [$event->id, $comment->id]) }}" class="btn btn-sm btn-warning">Modifier</a>

                    <form action="{{ route('user.events.comment.destroy', [$event->id, $comment->id]) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?')">Supprimer</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endforeach

</div>
@endsection
