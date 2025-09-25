@extends('layouts.app')

@section('title', 'Kalender Akademik')

@push('styles')
<style>
#calendar {
    max-width: 900px;
    margin: 0 auto;
    height: 600px;
    border: 1px solid #ddd;
}

.fc {
    font-family: Arial, sans-serif;
    font-size: 14px;
}

.fc .fc-toolbar-title {
    font-weight: bold;
}

.fc-daygrid-event {
    background-color: #3788d8;
    border-color: #3788d8;
    color: #fff;
    padding: 2px;
    border-radius: 3px;
}
</style>
@endpush

@section('content')
<h3>Kalender Akademik</h3>
<div id="calendar"></div>
@endsection

@push('scripts')
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var events = @json($kalender);

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        eventClick: function(info) {
            window.location.href = "/admin/kalender-akademik/" + info.event.id;
        }
    });

    calendar.render();
});
</script>
@endpush
