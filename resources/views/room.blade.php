@extends('layouts.page')
@section('content')
  <script>
    var roomData = {!! json_encode($roomData) !!};
    // === include 'setup' then 'config' above ===

    const myChart = new Chart(
        document.getElementById('environment'),
        {
          type: 'line',
          data: roomData,
          options: {}
        }
    );
  </script>
  <div class="py-10">
    <header>
      <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          {{ $room->name }} Climate Statistics
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div id="environment">
        </div>


        <!-- /End replace -->
      </div>
    </main>
  </div>
@endsection
