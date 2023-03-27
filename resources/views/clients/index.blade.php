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
                @if(checkMode() == 'server')
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.clients') }}'">ТАБЛЕТИ</button>
                @endif
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.logs') }}'">ЛОГОВЕ</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.qt') }}'">ДИАГНОСТИКА</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="disconnectAccount()">ИЗХОД ОТ СИСТЕМНОТО МЕНЮ</button>   
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

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Таблет име
                </th>
                <th scope="col" class="px-6 py-3">
                    Версия на софтуера
                </th>
                <th scope="col" class="px-6 py-3">
                    Мрежов адрес
                </th>
                <th scope="col" class="px-6 py-3">
                    Публичен ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Частен ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Дистрибутиращи настройки
                </th>
                <th scope="col" class="px-6 py-3">
                    Последна активност
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $client->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $client->version}}
                </td>
                <td class="px-6 py-4">
                    {{ $client->ip }}
                </td>
                <td class="px-6 py-4">
                    {{ $client->public_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $client->private_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $client->pinged_at }}
                </td>
                <td class="px-6 py-4">
                    
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Няма намерени параметри в базата данни!
                </th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $clients->links() }}
</div>
@push('js')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection