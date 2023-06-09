@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-4 m-7 pt-2">
    <div class="mt-6">
        <div class="flex justify-between px-14">
            <!--<p class="text-teal-custom font-roboto font-bold text-4xl">BCVT LOGO</p>-->
            <img src="{{ asset('img/bcvt-logo.png') }}" alt="bcvt logo" />
            <button id="lock_button" onclick="pinScreen()" disabled>
                <img src="{{ asset('img/icons/settings.png') }}" alt="settings"/>
            </button>
        </div>
        <div class="flex flex-col text-center mt-10">
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
    <div class="mt-6">
        <div class="flex justify-center">
            <img class="inline pr-10" src="{{ asset('img/weather/thunders.png') }}" alt="weather" />
            <p class="text-gray-dark font-roboto text-6xl">26°C</p>
        </div>
        <div class="flex justify-center mt-24">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА 26°C</p>
            <img class="inline" src="{{ asset('img/weather/rain.png') }}" alt="weather" />
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА 16°C</p>
            <img class="inline" src="{{ asset('img/weather/rain.png') }}" alt="weather" />
        </div>
        <div class="flex justify-center mt-7">
            <p class="text-white font-roboto">версия на софтуера: v.{{ $version }}</p>
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
@endpush
@endsection
