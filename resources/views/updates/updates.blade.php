@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="bg-blue-block p-10">
    <p class="text-xl text-white mb-5">Избор на дистрибуционнен софтуер за ъпдейт</p>
    <form method="POST" action="{{ route('admin.updates.settings.store') }}">
    @csrf
    <div class="grid grid-cols-6 gap-3">
    @foreach($updates as $update)
        <div class="mb-6">
            <label for="update_service" class="block mb-2 text-sm font-medium text-white dark:text-white">{{ $update->service }}</label>
            <select name="update_service[{{ $update->id}}]" class="bg-gray-50 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @if($update->status === true)
                <option value="1" selected>Включен</option>
                <option value="0">Изключен</option>
                @else
                <option value="0" selected>Изключен</option>
                <option value="1">Включен</option>
                @endif
            </select>
        </div>
    @endforeach
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Запази</button>
    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.clients') }}'">Отказ</button>
    </form>
</div>
@endsection