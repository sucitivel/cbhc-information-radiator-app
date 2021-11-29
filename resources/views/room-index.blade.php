@extends('layouts.page')
@section('content')
  <script>
    // === include 'setup' then 'config' above ===
    document.addEventListener('DOMContentLoaded', function() {
      const myChart = new Chart(
        document.getElementById('environment'),
        {
        type: 'line',
        data: {
          datasets:
          @foreach($rooms as $room)
          [{
            label: 'Humidity',
            data:  {!! json_encode($room->data_points['humidity']) !!},
            backgroundColor: '#00f',
            },{
            label: 'Temperature',
            data:  {!! json_encode($room->data_points['temperature']) !!},
            backgroundColor: '#f00',
          }],
          @endforeach
        },
        options: {}
        }
      );
    });
  </script>
  <div class="py-10">
    <header>
      <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          {{ $room->name }} Climate Statistics
          <form>
            <select onchange="this.form.submit()" name="room" class="float-right font-bold leading-tight text-gray-900">
                <option value="">All Rooms</option>
                @foreach($rooms as $label=>$id)
                    <option {{ (int)$selectedRoom === $id ? 'selected' : '' }} value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>
          </form>
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <canvas id="environment">
        </canvas>


        <!-- /End replace -->
      </div>
    </main>
  </div>
@endsection
