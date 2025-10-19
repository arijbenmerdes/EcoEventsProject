@extends('dashboard.index')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Statistiques des Événements</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Mois</th>
                <th>Nombre d’événements</th>
                <th>Total des participants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats as $stat)
                <tr>
                    <td>{{ $months[$stat->month] }}</td>
                    <td>{{ $stat->event_count }}</td>
                    <td>{{ $stat->total_participants ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <canvas id="eventsChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('eventsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stats->map(fn($s) => $months[$s->month])) !!},
            datasets: [
                {
                    label: 'Nombre d’événements',
                    data: {!! json_encode($stats->pluck('event_count')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                },
                {
                    label: 'Participants totaux',
                    data: {!! json_encode($stats->pluck('total_participants')) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
