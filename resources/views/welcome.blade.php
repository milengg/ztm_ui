@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-4 m-5 pt-2">
    <div>
        <div class="flex justify-between mt-3 px-14">
            <img src="{{ asset('img/bcvt-logo.png') }}" alt="bcvt logo" />
            <button id="lock_button" onclick="pinScreen()" disabled>
                <img src="{{ asset('img/icons/settings.png') }}" alt="settings"/>
            </button>
        </div>
        <div class="flex flex-col text-center mt-8">
            <div id="clock" class="text-white text-center font-roboto text-9xl">{{ date('H:i') }}</div>
            <div id="date" class="text-teal-dark text-center font-roboto pl-5 mt-5 text-5xl">{{ bgDate('d M Y') }}</div>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <livewire:climate />
    </div>
    <div class="bg-blue-block rounded-3xl">
        <livewire:lights />
    </div>
    <div class="mt-5">
        <div class="flex justify-center">
            <img id="forecast_icon_1" class="inline pr-10" width="120px" alt="weather1" />
            <p id="forecast_temp_1" class="text-gray-dark font-roboto text-6xl">0°C</p>
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА <span id="forecast_temp_2">0°C</span></p>
            <img id="forecast_icon_2" width="75px" class="inline" alt="weather2" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА <span id="forecast_temp_3">0°C</span></p>
            <img id="forecast_icon_3" width="75px" class="inline" alt="weather3" />
        </div>
        <div class="flex justify-between mx-14 mt-7">
            <div class="mt-8 text-center">
                <p class="text-white font-roboto font-bold text-4xl">{{ $hostname->parameter_value ?? 'ЛИПСВА' }}</p>
            </div>
            <img class="rounded" src="{{ asset('img/bcvt-qr.png') }}" width="100" alt="qr code" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-white font-roboto">версия на ztmUI: v.{{ $version }}</p>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <livewire:vent />
    </div>
    <div class="bg-blue-block rounded-3xl">
        <livewire:blinds />
    </div>
</div>
@push('js')
<script src="{{ asset('js/clock.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/lock.js') }}"></script>
<script>
    $(document).ready(function() {
        function fetchWeather() {
            $.ajax({
                url: '/weather',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#forecast_temp_1').empty();
                    $('#forecast_temp_2').empty();
                    $('#forecast_temp_3').empty();
                    //Icon
                    var forecast_icon_url1 = 'weather-icons/' + response[4].value + '.svg';
                    var forecast_icon_url2 = 'weather-icons/' + response[8].value + '.svg';
                    var forecast_icon_url3 = 'weather-icons/' + response[12].value + '.svg';
                    $('#forecast_icon_1').attr('src', forecast_icon_url1);
                    $('#forecast_icon_2').attr('src', forecast_icon_url2);
                    $('#forecast_icon_3').attr('src', forecast_icon_url3);
                    //Temp
                    $('#forecast_temp_1').append(response[6].value + '°C');
                    $('#forecast_temp_2').append(response[10].value + '°C');
                    $('#forecast_temp_3').append(response[14].value + '°C');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        fetchWeather();
        setInterval(fetchWeather, 5000);
    });
</script>
@endpush
@endsection
