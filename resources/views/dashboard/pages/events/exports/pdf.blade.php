<h1>Liste des événements</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Lieu</th>
            <th>Participants</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->description }}</td>
                <td>{{ optional($event->start_date)->format('d/m/Y') }}</td>
                <td>{{ optional($event->end_date)->format('d/m/Y') }}</td>
                <td>{{ $event->location }}</td>
                <td>{{ $event->participants_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
