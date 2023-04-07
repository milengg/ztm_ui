@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

@if(checkMode() == 'server')
<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ ТАБЛЕТ</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">НАСТРОЙКА ЪПДЕЙТИ</button>
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
                    Етаж
                </th>
                <th scope="col" class="px-6 py-3">
                    Стая
                </th>
                <th scope="col" class="px-6 py-3">
                    Публичен ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Частен ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Ъпдейти
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
            @forelse($tablets as $tablet)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $tablet->tablet_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $tablet->version ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->ip ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->floor ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->room ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->public_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->private_key ? 'Да':'Не'}}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->distribute_settings ? 'Пуснати':'Спрени' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->pinged_at ?: 'В очакване' }}
                </td>
                <td class="px-6 py-4">
                    <button type="button" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">Ключ</button>
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Няма намерени данни
                </th>
                <td></td>
                <td></td>
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
    {{ $tablets->links() }}
</div>
@elseif(checkMode() == 'client')
<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ СЪРВЪР</button>
</div>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Сървър име
                </th>
                <th scope="col" class="px-6 py-3">
                    Мрежов адрес на сървъра
                </th>
                <th scope="col" class="px-6 py-3">
                    Собствен мрежов адрес
                </th>
                <th scope="col" class="px-6 py-3">
                    Публичен ключ
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($servers as $server)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $server->server_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $server->server_ip }}
                </td>
                <td class="px-6 py-4">
                    {{ $server->tablet_ip }}
                </td>
                <td class="px-6 py-4">
                    {{ $server->public_key ? 'Да':'Не' }}
                </td>
                <td class="px-6 py-4">
                    <button type="button" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">Редакция</button>
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Няма намерени данни
                </th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $servers->links() }}
</div>
@endif
@push('js')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection