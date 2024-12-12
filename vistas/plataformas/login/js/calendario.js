import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

const calendar = new Calendar(document.getElementById('calendar'), {
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  events: async function(info, successCallback, failureCallback) {
    // Llamada a tu API para obtener las fechas de reserva
    const response = await fetch('/api/reservas');
    const reservas = await response.json();
    
    // Filtrar las reservas y marcar en el calendario
    const eventos = reservas.map(reserva => ({
      title: 'Reservado',
      start: reserva.fecha_inicio,
      end: reserva.fecha_fin,
      backgroundColor: 'red',
      textColor: 'white'
    }));

    successCallback(eventos);
  },
  dateClick: function(info) {
    alert('Fecha seleccionada: ' + info.dateStr);
  }
});

calendar.render();