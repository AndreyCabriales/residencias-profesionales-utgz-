import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendario-container');

    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            locale: 'es', // Set language to Spanish since app is in Spanish
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: window.calendarEventsUrl || '/api/v1/calendario', // Consumes the GET /api/v1/calendario endpoint via fetch internally
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                
                // Dispatch event to Alpine.js modal
                window.dispatchEvent(new CustomEvent('open-event-modal', {
                    detail: {
                        id: info.event.id,
                        title: info.event.title,
                        start: info.event.start,
                        end: info.event.end,
                        extendedProps: info.event.extendedProps
                    }
                }));
            },
            selectable: true,
            select: function(info) {
                // Only Asesores can create via calendar select (this role check will be handled or hidden in Blade)
                window.dispatchEvent(new CustomEvent('open-create-modal', {
                    detail: { start: info.startStr, end: info.endStr }
                }));
            },
            height: 'auto',
            themeSystem: 'standard'
        });

        calendar.render();
    }
});
