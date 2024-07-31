import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import bootstrapPlugin from '@fullcalendar/bootstrap';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const events = window.calendarEvents || [];

        var calendar = new Calendar(calendarEl, {
            plugins: [listPlugin, timeGridPlugin, dayGridPlugin, interactionPlugin, bootstrapPlugin],
            themeSystem: 'bootstrap',
            initialView: 'listWeek',
            editable: true,
            selectable: true,
            events: events,
            dateClick: handleDateClick,
            eventClick: handleEventClick,
            select: handleSelect,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'listWeek,dayGridMonth,timeGridWeek,timeGridDay'
            }
        });
        calendar.render();
    }
});

function handleDateClick(info) {
    const { dateStr } = info;
    const [datePart, timePart] = dateStr.split('T');

    let startDate = new Date(datePart);
    let endDate = new Date(datePart);

    if (timePart) {
        startDate = new Date(dateStr);
        endDate = new Date(startDate);
        endDate.setHours(endDate.getHours() + 1);
    } else {
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(23, 59, 59, 999);
    }

    updateFormFields(startDate, endDate);
    scrollToForm();
}

function handleSelect(info) {
    const { startStr, endStr } = info;
    const [_, timePartStart] = startStr.split('T');

    let startDate = new Date(startStr);
    let endDate = new Date(endStr);

    if (!timePartStart) {
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(23, 59, 59, 999);
        endDate.setDate(endDate.getDate() - 1);
    }

    updateFormFields(startDate, endDate);
    scrollToForm();
}

function handleEventClick(info) {
    if (confirm(`Do you want to delete event ${info.event.title}?`)) {
        const { id: eventId, extendedProps: { calendar_id: calendarId } } = info.event;

        axios.delete(`/calendars/${calendarId}/events/${eventId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(() => {
            info.event.remove();
            alert('Event deleted successfully.');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the event.');
        });
    }
}

function updateFormFields(startDate, endDate) {
    document.getElementById('start_date').value = formatDateForInput(startDate);
    document.getElementById('end_date').value = formatDateForInput(endDate);
}

function formatDateForInput(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function scrollToForm() {
    const form = document.getElementById('add-event-form');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
