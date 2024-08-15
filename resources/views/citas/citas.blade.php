@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#3085d6',
        });
    });
</script>
@endif

<a href="{{ route('citas.create') }}" class="button">Agregar Cita</a>
<a href="{{ route('citas.tablacitas') }}" class="button">Ver todas las citas</a>
<div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="lg:w-10/12 md:w-11/12 sm:w-full mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex items-center justify-between px-6 py-3 bg-gray-700">
                <button id="prevMonth" class="text-white">Previous</button>
                <h2 id="currentMonth" class="text-white"></h2>
                <button id="nextMonth" class="text-white">Next</button>
            </div>
            <div class="grid grid-cols-7 gap-2 p-4" id="calendar" style="min-height: 600px;">
                <!-- Calendar Days Go Here -->
            </div>
            <div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
              <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
            
              <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                  <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Selected Date</p>
                    <button id="closeModal" class="modal-close px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring">✕</button>
                  </div>
                  <div id="modalDate" class="text-xl font-semibold"></div>
                  <div id="modalAppointments" class="mt-4"></div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
const citas = @json($citas);

// Function to generate the calendar for a specific month and year
function generateCalendar(year, month) {
    const calendarElement = document.getElementById('calendar');
    const currentMonthElement = document.getElementById('currentMonth');
    
    // Create a date object for the first day of the specified month
    const firstDayOfMonth = new Date(year, month, 1);
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    // Clear the calendar
    calendarElement.innerHTML = '';

    // Set the current month text
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    currentMonthElement.innerText = `${monthNames[month]} ${year}`;
    
    // Calculate the day of the week for the first day of the month (0 - Sunday, 1 - Monday, ..., 6 - Saturday)
    const firstDayOfWeek = firstDayOfMonth.getDay();

    // Create headers for the days of the week
    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    daysOfWeek.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.className = 'text-center font-semibold';
        dayElement.innerText = day;
        calendarElement.appendChild(dayElement);
    });

    // Create empty boxes for days before the first day of the month
    for (let i = 0; i < firstDayOfWeek; i++) {
        const emptyDayElement = document.createElement('div');
        calendarElement.appendChild(emptyDayElement);
    }

    // Create boxes for each day of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'text-center py-2 border cursor-pointer relative';
        dayElement.innerText = day;

        // Add the number of citas for the day
        const dayDate = new Date(year, month, day);
        const citasForDay = citas.filter(cita => new Date(cita.fecha).toDateString() === dayDate.toDateString());

        if (citasForDay.length > 0) {
            const citasCount = document.createElement('span');
            citasCount.className = 'absolute bottom-0 right-0 bg-blue-500 text-white rounded-full px-2';
            citasCount.innerText = citasForDay.length;
            dayElement.appendChild(citasCount);
        }

        // Check if this date is the current date
        const currentDate = new Date();
        if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
            dayElement.classList.add('bg-blue-500', 'text-white'); // Add classes for the indicator
        }

        calendarElement.appendChild(dayElement);
    }

}

// Initialize the calendar with the current month and year
const currentDate = new Date();
let currentYear = currentDate.getFullYear();
let currentMonth = currentDate.getMonth();
generateCalendar(currentYear, currentMonth);

// Event listeners for previous and next month buttons
document.getElementById('prevMonth').addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar(currentYear, currentMonth);
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar(currentYear, currentMonth);
});

// Function to show the modal with the selected date
function showModal(selectedDate, citasForDay) {
    const modal = document.getElementById('myModal');
    const modalDateElement = document.getElementById('modalDate');
    const modalAppointmentsElement = document.getElementById('modalAppointments');
    
    modalDateElement.innerText = selectedDate;
    modalAppointmentsElement.innerHTML = '';
    
    if (citasForDay.length > 0) {
        const citasList = document.createElement('ul');
        citasForDay.forEach(cita => {
            const citaItem = document.createElement('li');
            citaItem.innerText = `${cita.hora} - ${cita.paciente.nombres}`;
            citasList.appendChild(citaItem);
        });
        modalAppointmentsElement.appendChild(citasList);
    } else {
        modalAppointmentsElement.innerText = 'No appointments';
    }
    
    modal.classList.remove('hidden');
}

// Function to hide the modal
function hideModal() {
    const modal = document.getElementById('myModal');
    modal.classList.add('hidden');
}

// Event listener for date click events
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('cursor-pointer')) {
        const day = parseInt(event.target.innerText);
        const selectedDate = new Date(currentYear, currentMonth, day);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = selectedDate.toLocaleDateString(undefined, options);

        const citasForDay = citas.filter(cita => new Date(cita.fecha).toDateString() === selectedDate.toDateString());
        
        showModal(formattedDate, citasForDay);
    }
});

// Event listener for closing the modal
document.getElementById('closeModal').addEventListener('click', () => {
    hideModal();
});
</script>
@endsection
