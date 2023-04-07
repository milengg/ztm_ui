@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI v.{{ $info['platform-version'] }}</h1>
</div>

<div class="grid grid-cols-1">
    <div class="bg-blue-dark p-4">
        <div class="flex justify-between">
            <div>
                @if(checkMode() == 'server')
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Сървър</span></h2>
                @elseif(checkmode() == 'client')
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Клиент</span></h2>
                @else
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Липсва настройка</span></h2>
                @endif
            </div>
            <div>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.index') }}'">ПАРАМЕТРИ</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.logs') }}'">ЛОГОВЕ</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.qt') }}'">ДИАГНОСТИКА</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="disconnectAccount()">ИЗХОД ОТ СИСТЕМНОТО МЕНЮ</button>    
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-white">ztmUI версия</p>
                <p class="text-lg text-white"><a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('admin.changelog') }}">{{ $info['platform-version'] }}</a></p>
            </div>
            <div>
                <p class="text-sm text-white">PHP версия</p>
                <p class="text-lg text-white">{{ $info['php-version'] }}</p>
            </div>
            <div>
                <p class="text-sm text-white">Мрежов адрес</p>
                <p class="text-lg text-white">{{ $info['tablet-ip'] }}</p>
            </div>
            <div>
                <p class="text-sm text-white">Curl плъгин</p>
                <p class="text-lg text-white">{{ $info['curl-status'] ? 'Активен':'Неактивен' }}</p>
            </div>
            <div>
                <p class="text-sm text-white">OS ядро</p>
                <p class="text-lg text-white">{{ $info['os-core'] }}</p>
            </div>
            <div>
                <p class="text-sm text-white">Framework ядро</p>
                <p class="text-lg text-white">{{ $info['framework'] }}</p>
            </div>
        </div>
    </div>
</div>

@if(checkMode() == 'server')
<div class="bg-blue-block mt-10 p-10">
    <p class="text-xl text-white mb-5">Добавяне на таблет</p>
    <form method="POST" action="{{ route('admin.clients.create') }}">
      @csrf
      <div class="mb-6">
        <label for="client_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Име таблет</label>
        <input type="text" name="client_name" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="bg-gray-50 border border-gray-300 js-virtual-keyboard text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добави</button>
    </form>
</div>
@elseif(checkMode() == 'client')
<div class="bg-blue-block mt-10 p-10">
    <p class="text-xl text-white mb-5">Добавяне на настройки за сървър</p>
    <form method="POST" action="{{ route('admin.clients.server.create') }}">
      @csrf
      <div class="mb-6">
        <label for="server_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Име сървър</label>
        <input type="text" name="server_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
      </div>
      <div class="mb-6">
        <label for="server_ip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Мрежов адрес на сървър</label>
        <input type="text" name="server_ip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
      </div>
      <div class="mb-6">
        <label for="server_key" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Криптиращ ключ</label>
        <textarea name="server_key" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Публичен ключ..." required></textarea>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добави</button>
    </form>
</div>
@endif
@push('js')
<script src="{{ asset('js/keyboard-init.js') }}"></script>
<script>
    KioskBoard.run('.js-virtual-keyboard', {});
</script>
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection