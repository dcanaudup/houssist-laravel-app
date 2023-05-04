<div wire:ignore x-data="{
    init() {
        const events = @js($events);
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month, agendaWeek',
                },
                initialView: 'dayGridMonth',
                plugins: [ dayGridPlugin ],
                events: events
                });
                calendar.render();
        });
        }
    }
">
    <h1 class="text-4xl font-semibold text-gray-900">Calendar</h1>
    <div class="bg-white p-4 mt-2" id="calendar"></div>
</div>
