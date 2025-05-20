import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
//Language might want to try make this import dynamic
import LangLocale from '@fullcalendar/core/locales/fr';
//calendartests css override test
import './styles/Calendar_Style.css';

//File load test:
//console.log("File loaded");

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');
    const eventListEl = document.getElementById('event-list');

    if (calendarEl && eventListEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, timeGridPlugin, interactionPlugin ],
            initialView: 'dayGridMonth',
            locale: LangLocale,
            editable: true,
            selectable: true,
            fixedWeekCount: false,
            showNonCurrentDates: true,
            headerToolbar: {
                left: 'prev',
                center: 'title today',
                right: 'next'
              },
              events: {
                url: '/api/appointments',
                failure: function(error) {
                  console.error('❌ Failed to load events:', error);
                  alert('Failed to load events. Check the console.');
                },
                extraParams: {
                  debug: true
                }
              },//current test route

              //test if events load properly :
            //   eventsSet: function(events) {
            //     console.log('Events loaded:', events);
            //   },

            eventDidMount: function() {
                // Called once per event render — but wait to group all for performance
                setTimeout(() => {
                    renderEventCounters();
                }, 0);
            },
            
            //Allows click on individual cells and creates the div with the current day events

            dateClick: function(info) {
                document.querySelectorAll('.fc-daygrid-day').forEach(el =>
                    el.classList.remove('fc-selected')
                );
                
                //css call
                info.dayEl.classList.add('fc-selected');
            
                // What runs when you click a date
                const clickedDate = info.dateStr;
                const events = calendar.getEvents().filter(event => event.startStr.startsWith(clickedDate));
                renderEventList(events, clickedDate);
            },

            //Enabling the "today" button to be always clickable
            //Also selects the current day
            datesSet: function () {
                const todayButton = document.querySelector('.fc-today-button');
            
                if (todayButton) {
                    todayButton.disabled = false;
                    todayButton.classList.remove('fc-button-disabled');
            
                    todayButton.addEventListener('click', () => {
                        const todayDate = new Date().toISOString().split('T')[0]; // format: YYYY-MM-DD
                        const todayCell = document.querySelector(`[data-date="${todayDate}"]`);
            
                        if (todayCell) {
                            // Clear old selection
                            document.querySelectorAll('.fc-daygrid-day').forEach(el =>
                                el.classList.remove('fc-selected')
                            );
            
                            // Add highlight class
                            todayCell.classList.add('fc-selected');
            
                            // Filter events for today
                            const events = calendar.getEvents().filter(event =>
                                event.startStr.startsWith(todayDate)
                            );
            
                            renderEventList(events, todayDate);
                        }
                    }, { once: true }); //this makes sure the event is created once by render (chatgpt)
                }
                //test:
                renderEventCounters();
            },
        });

        calendar.render();
      
        //Render the events from the calendar on a separate div

        function renderEventList(events, dateStr) {
            if (events.length === 0) {
                eventListEl.innerHTML = `
                    <h3 class="text-xl font-semibold mb-4">${formatDateFr(dateStr)}</h3>
                    <p class="text-gray-500">Aucun événement prévu.</p>
                `;
                return;
            }
        
            let html = `<h3 class="text-xl font-semibold mb-4">${formatDateFr(dateStr)}</h3>`;
        
            events.forEach(event => {
                const id = event.id;
                const startTime = event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
                const lastname = event.extendedProps.customer_lastname || '';
                const firstname = event.extendedProps.customer_name || '';
                const serviceName = event.extendedProps.type_names?.[0] || '';
                const customerAdress = event.extendedProps.customer_address || '';
            
                html += `
                    <a href="/booking/${id}" class="flex items-start justify-between mb-4 p-4 rounded-xl bg-white shadow-sm border-l-4 border-[#8464f4] hover:bg-gray-50 transition">
                        <p class="text-sm font-semibold text-gray-800 w-12">${startTime}</p>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900">${firstname} ${lastname}</p>
                            <p class="text-sm text-gray-500">${serviceName}</p>
                            <p class="text-sm text-gray-500">${customerAdress}</p>    
                        </div>
                    </a>
                `;
            });
        
            eventListEl.innerHTML = html;
        }
        
        
        //Create a function to render the dates in a string 
        //will need to modify the ('fr-FR') argument to make it dynamic on other languages

        function formatDateFr(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }

        //Trying to add appointement counter at the top of the day cells

        function renderEventCounters() {
            const allEvents = calendar.getEvents();
            const allCells = document.querySelectorAll('.fc-daygrid-day');
        
            allCells.forEach(cell => {
                const cellDate = cell.getAttribute('data-date');
                const eventsForDay = allEvents.filter(ev => ev.startStr.startsWith(cellDate));
        
                // Remove old counter if any
                const oldCounter = cell.querySelector('.event-counter');
                if (oldCounter) oldCounter.remove();
        
                if (eventsForDay.length > 0) {
                    const counter = document.createElement('div');
                    counter.textContent = `${eventsForDay.length}`;
                    counter.className = 'event-counter absolute top-1 right-1 bg-[#b49cf5] text-white text-xs px-2 py-0.5 rounded-full shadow';
                    
                    cell.style.position = 'relative';
                    cell.appendChild(counter);
                }
            });
        }
        
    }
});