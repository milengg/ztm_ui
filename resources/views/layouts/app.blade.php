<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ztmUI</title>

        <!-- CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/range-slider.css') }}">
        <!-- Livewire -->
        @livewireStyles
        <!-- Jquery -->
        <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
        <!-- Toastr Notifications -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <!-- keyboard -->
        <script src="{{ asset('js/kioskboard-aio-2.3.0.min.js') }}"></script>
    </head>
    <body class="antialiased bg-blue-body">
        <main>
            @yield('content')
            <livewire:lock />
        </main>
        <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
        @livewireScripts
        @stack('js')

        <script>
            @if(Session::has('message'))
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.success("{{ session('message') }}");
            @endif
  
            @if(Session::has('error'))
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.error("{{ session('error') }}");
            @endif
  
            @if(Session::has('info'))
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.info("{{ session('info') }}");
            @endif
  
            @if(Session::has('warning'))
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.warning("{{ session('warning') }}");
            @endif
        </script>
    </body>
</html>
