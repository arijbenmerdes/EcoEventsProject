@extends('user.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Modifier votre commentaire</h2>

    <form action="{{ route('user.events.comment.update', [$event->id, $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <textarea name="comment" class="form-control" required>{{ $comment->comment }}</textarea>
        </div>
        <div class="mb-2">
            <select name="rating" class="form-control">
                <option value="">Note (optionnelle)</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}" {{ $comment->rating == $i ? 'selected' : '' }}>{{ $i }} étoiles</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
