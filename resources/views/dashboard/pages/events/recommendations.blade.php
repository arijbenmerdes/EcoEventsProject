@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Événements recommandés</h1>

    @if(count($events) > 0)
        <ul>
            @foreach($events as $event)
                <li>
                    <strong>{{ $event['title'] }}</strong> - Catégories : {{ implode(', ', $event['preferred_categories'] ?? []) }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune recommandation pour le moment.</p>
    @endif
</div>
@endsection
