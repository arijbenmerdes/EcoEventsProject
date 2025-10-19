@extends('user.dashboard')
@section('content') 
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Calendrier des Événements</title>

  <!-- ✅ FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

  <style>
    body {
      margin: 40px 10px;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f8f9fa;
    }

    #calendar {
      max-width: 1100px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      padding: 20px;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center; color:#28a745;">Calendrier des Événements</h2>
  <div id="calendar"></div>

  <!-- ✅ FullCalendar JS (version globale) -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/api/events',
        eventColor: '#28a745',
        eventTextColor: 'white',
        eventClick: function(info) {
          alert('Événement : ' + info.event.title + '\nDate : ' + info.event.start.toLocaleDateString());
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>
@endsection