import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import bootstrapPlugin from '@fullcalendar/bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin, bootstrapPlugin],
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: [
                {
                    title: 'PlaceHolder',
                    start: '2024-07-01',
                    end: '2024-07-02'
                }
            ],
            dateClick: function(info) {
                alert('Date clicked: ' + info.dateStr);
            },
            eventClick: function(info) {
                alert('Event clicked: ' + info.event.title);
            }
        });
        calendar.render();
    }
});