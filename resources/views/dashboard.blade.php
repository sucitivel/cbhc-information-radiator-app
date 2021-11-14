@extends('layouts.page')
@section('content')
  <script>
    var myEvents = {!! json_encode($events) !!};
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
