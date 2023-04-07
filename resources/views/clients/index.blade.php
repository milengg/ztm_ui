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
            <div class="mb-2">
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
<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ ТАБЛЕТ</button>
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
                    {{ $client->client_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $client->version ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $client->ip ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $client->public_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $client->private_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $client->distribute_settings ? 'Да':'Не' }}
                </td>
                <td class="px-6 py-4">
                    {{ $client->pinged_at ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    <button type="button" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">Виж ключ</button>
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
@elseif(checkMode() == 'client')
<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ КЛЮЧ КЪМ СЪРВЪР</button>
</div>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Сървър име
                </th>
                <th scope="col" class="px-6 py-3">
                    Мрежов Адрес
                </th>
                <th scope="col" class="px-6 py-3">
                    Добавен Ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($client_settings as $setting)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $setting->server_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $setting->server_ip }}
                </td>
                <td class="px-6 py-4">
                    {{ $setting->server_key ? 'Да':'Не' }}
                </td>
                <td class="px-6 py-4">
                    <button type="button" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">Редакция</button>
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
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $clients->links() }}
</div>
@endif
@push('js')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection