@extends('menu')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="calendar"></div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales-all.global.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es', // idioma español
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: @json($data),

                eventDidMount: function(info) {
                    // Asegura que se aplique el color
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    info.el.style.borderColor = info.event.borderColor;
                    info.el.style.color = info.event.textColor;

                    // Tooltip con la descripción
                    if (info.event.extendedProps.description) {
                        info.el.setAttribute('title', info.event.extendedProps.description);
                    }
                },

                dateClick: function(info) {
                    alert('Seleccionaste la fecha: ' + info.dateStr);
                }
            });

            calendar.render();
        });
    </script>
@endsection
