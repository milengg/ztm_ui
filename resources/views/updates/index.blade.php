@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

@if(checkMode() == 'server')
<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ ТАБЛЕТ</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.updates.settings') }}'">НАСТРОЙКА ЪПДЕЙТИ</button>
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
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
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
                <td class="px-6 py-4 flex">
                    <button service_id="{{ $tablet->id }}" type="button" class="allow_updates mr-2 text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </button>
                    <a href="{{ route('admin.download.publickey', $tablet->id) }}" class="mr-2 text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.clients.delete', $tablet->id) }}" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <td scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
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
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
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
                <td class="px-6 py-4 flex">
                    <a href="{{ route('admin.server.delete', $server->id) }}" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
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
<script>
$(document).ready(function() {
    $('.allow_updates').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('service_id');
        $.ajax({
            url: '/panel/updates/allow',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: id },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});
</script>
@endpush
@endsection