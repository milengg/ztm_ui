@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.automatic.discovery') }}'">АВТОМАТИЧНО ОТКРИВАНЕ</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients.add') }}'">ДОБАВИ ТАБЛЕТ РЪЧНО</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.updates.settings') }}'">НАСТРОЙКА ЪПДЕЙТИ</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.groups') }}'">ГРУПИ</button>
</div>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Таблет сериен номер
                </th>
                <th scope="col" class="px-6 py-3">
                    Таблет мрежов адрес
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($tablets as $tablet)
            <tr class="bg-blue-dark border-b border-blue-block">
                <td class="px-6 py-4">
                    {{ $tablet->serial }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->ip }}
                </td>
                <td class="px-6 py-4 flex">
                    <a href="{{ route('admin.automatic.discovery.add', $tablet->serial) }}" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $tablets->links() }}
</div>
@endsection