@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="mt-2 mx-4">
    <div class="grid grid-cols-4 gap-4">
    @forelse($contents as $content)
        <div>
            <p class="text-white font-bold">Версия ъпдейт: {{ $content->version }}</p>
            <p class="text-white">Тип: {{ $content->type }}</p>
            <p class="text-white">Промени: {{ $content->content }}</p>
        </div>
    @empty
        <div>
            <p class="text-white font-bold">няма данни за момента </p>
        </div>
    @endforelse
    </div>
</div>

@endsection