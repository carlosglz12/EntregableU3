@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/calendario.css') }}">

@section('content')

<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var citas = @json($citas);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      themeSystem: 'bootstrap',
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      events: citas,
      eventClick: function(info) {
        alert('Paciente: ' + info.event.title + '\n' + info.event.extendedProps.description);
      },
      eventMouseEnter: function(mouseEnterInfo) {
        mouseEnterInfo.el.style.cursor = 'pointer';
      }
    });
    calendar.render();
  });
</script>

<div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
    <a href="{{ route('citas.create') }}" class="btn btn-primary">Agregar Cita</a>
    <a href="{{ route('citas.tablacitas') }}" class="btn btn-secondary">Ver todas las citas</a>
  </div>
  <div id='calendar'></div>
</div>

@endsection
