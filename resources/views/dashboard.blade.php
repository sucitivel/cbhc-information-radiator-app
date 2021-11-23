@extends('layouts.page')
@section('content')
  <script>
    var myEvents = {!! json_encode($events) !!};

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new Calendar(calendarEl, {
        plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: myEvents,
        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
      });

      calendar.render();
    })
  </script>
  <div class="py-10">
    <header>
      <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          Daily Checklist
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div id="calendar">
        </div>


        <!-- /End replace -->
      </div>
    </main>
  </div>
@endsection
